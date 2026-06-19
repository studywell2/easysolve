<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeManager();

        $schoolId = auth()->user()->school_id;
        $query = User::where('school_id', $schoolId);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15)->appends($request->query());

        return view('school.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeManager();
        $school = auth()->user()->school;
        $classes = $school->classes()->active()->with('sections')->get();
        $parents = User::where('school_id', $school->id)->where('role', 'parent')->orderBy('first_name')->get();
        $subjects = Subject::where('school_id', $school->id)->orderBy('name')->get();

        return view('school.users.create', compact('classes', 'parents', 'subjects'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student,parent',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'section_id' => 'nullable|exists:sections,id',
            'parent_id' => ['nullable', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'parent')],
            'subjects' => 'nullable|array',
            'subjects.*' => [Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
        ]);

        // Verify section belongs to the selected class in this school
        if (!empty($validated['section_id']) && !empty($validated['class_id'])) {
            $validSection = \App\Models\Section::where('id', $validated['section_id'])
                ->where('class_id', $validated['class_id'])->exists();
            if (!$validSection) {
                return back()->withErrors(['section_id' => 'The selected section does not belong to the selected class.'])->withInput();
            }
        }

        $validated['school_id'] = $schoolId;
        $validated['password'] = Hash::make($validated['password']);

        $subjects = $validated['subjects'] ?? [];
        unset($validated['subjects']);

        $user = User::create($validated);
        $user->subjects()->sync($subjects);

        return redirect()->route('school.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $this->authorizeAccess($user);
        $this->authorizeManager();
        $user->load(['schoolClass', 'section', 'attendances', 'grades', 'payments']);

        return view('school.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorizeAccess($user);
        $this->authorizeManager();
        $classes = auth()->user()->school->classes()->active()->with('sections')->get();
        $parents = User::where('school_id', $user->school_id)->where('role', 'parent')->orderBy('first_name')->get();
        $subjects = Subject::where('school_id', $user->school_id)->orderBy('name')->get();
        $user->load('subjects');

        return view('school.users.edit', compact('user', 'classes', 'parents', 'subjects'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAccess($user);
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin,teacher,student,parent',
            'class_id' => ['nullable', Rule::exists('classes', 'id')->where('school_id', $schoolId)],
            'section_id' => 'nullable|exists:sections,id',
            'parent_id' => ['nullable', Rule::exists('users', 'id')->where('school_id', $schoolId)->where('role', 'parent')],
            'subjects' => 'nullable|array',
            'subjects.*' => [Rule::exists('subjects', 'id')->where('school_id', $schoolId)],
        ]);

        // Verify section belongs to the selected class in this school
        if (!empty($validated['section_id']) && !empty($validated['class_id'])) {
            $validSection = \App\Models\Section::where('id', $validated['section_id'])
                ->where('class_id', $validated['class_id'])->exists();
            if (!$validSection) {
                return back()->withErrors(['section_id' => 'The selected section does not belong to the selected class.'])->withInput();
            }
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $subjects = $validated['subjects'] ?? [];
        unset($validated['subjects']);

        $user->update($validated);
        $user->subjects()->sync($subjects);

        return redirect()->route('school.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorizeAccess($user);
        $this->authorizeManager();

        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('school.users.index')->with('success', 'User deleted successfully.');
    }

    private function authorizeAccess(User $user): void
    {
        if ($user->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }

    private function authorizeManager(): void
    {
        if (!auth()->user()->canManageSchool()) {
            abort(403, 'You do not have permission to perform this action.');
        }
    }
}