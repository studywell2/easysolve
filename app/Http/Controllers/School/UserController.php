<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Mail\UserWelcomeMail;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

        // Generate a secure random temporary password
        $tempPassword = Str::random(12);
        $validated['password'] = Hash::make($tempPassword);

        $subjects = $validated['subjects'] ?? [];
        unset($validated['subjects']);

        $user = User::create($validated);
        $user->subjects()->sync($subjects);

        // Send welcome email
        Mail::to($user->email)->queue(new UserWelcomeMail($user, $tempPassword));

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
            $request->validate(['password' => 'string|min:8|confirmed']);
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

    // ─── CSV Import ───────────────────────────────────

    public function showImportForm()
    {
        $this->authorizeManager();
        return view('school.users.import');
    }

    public function import(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        $headers = fgetcsv($handle);

        if (!$headers) {
            return back()->with('error', 'The CSV file appears to be empty or invalid.');
        }

        // Normalize headers
        $headers = array_map(fn($h) => strtolower(trim($h)), $headers);

        $required = ['first_name', 'last_name', 'email', 'role'];
        foreach ($required as $col) {
            if (!in_array($col, $headers)) {
                fclose($handle);
                return back()->with('error', "Missing required column: {$col}. Required columns: first_name, last_name, email, role. Optional: class_name, section_name, parent_email.");
            }
        }

        // Preload class & section lookups for this school
        $classes = SchoolClass::where('school_id', $schoolId)->pluck('id', 'name');
        $parents = User::where('school_id', $schoolId)->where('role', 'parent')->pluck('id', 'email');

        $created = 0;
        $skipped = 0;
        $errors = [];
        $rowNumber = 1;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                $data = array_combine($headers, $row);

                if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email'])) {
                    $skipped++;
                    $errors[] = "Row {$rowNumber}: Missing required fields — skipped.";
                    continue;
                }

                $email = strtolower(trim($data['email']));

                // Skip if email already exists
                if (User::where('email', $email)->exists()) {
                    $skipped++;
                    $errors[] = "Row {$rowNumber}: {$email} already exists — skipped.";
                    continue;
                }

                $role = strtolower(trim($data['role'] ?? 'student'));
                if (!in_array($role, ['admin', 'teacher', 'student', 'parent'])) {
                    $skipped++;
                    $errors[] = "Row {$rowNumber}: Invalid role '{$role}' — skipped.";
                    continue;
                }

                // Resolve class
                $classId = null;
                if (!empty($data['class_name'])) {
                    $classId = $classes[$data['class_name']] ?? null;
                    if (!$classId && $role === 'student') {
                        $skipped++;
                        $errors[] = "Row {$rowNumber}: Class '{$data['class_name']}' not found — skipped.";
                        continue;
                    }
                }

                // Resolve section
                $sectionId = null;
                if (!empty($data['section_name']) && $classId) {
                    $section = Section::where('class_id', $classId)->where('name', $data['section_name'])->first();
                    if ($section) {
                        $sectionId = $section->id;
                    }
                }

                // Resolve parent
                $parentId = null;
                if (!empty($data['parent_email'])) {
                    $parentEmail = strtolower(trim($data['parent_email']));
                    $parentId = $parents[$parentEmail] ?? null;
                    if (!$parentId && $role === 'student') {
                        // Create parent if doesn't exist
                        $parentPassword = Str::random(12);
                        $parent = User::create([
                            'school_id' => $schoolId,
                            'first_name' => 'Parent',
                            'last_name' => $data['last_name'],
                            'email' => $parentEmail,
                            'password' => Hash::make($parentPassword),
                            'role' => 'parent',
                            'is_active' => true,
                        ]);
                        $parentId = $parent->id;
                        $parents[$parentEmail] = $parentId;

                        Mail::to($parentEmail)->queue(new UserWelcomeMail($parent, $parentPassword));
                        $created++;
                    }
                }

                // Generate a secure random temporary password for each imported user
                $userPassword = Str::random(12);
                $newUser = User::create([
                    'school_id' => $schoolId,
                    'parent_id' => $parentId,
                    'class_id' => $classId,
                    'section_id' => $sectionId,
                    'first_name' => trim($data['first_name']),
                    'last_name' => trim($data['last_name']),
                    'email' => $email,
                    'password' => Hash::make($userPassword),
                    'role' => $role,
                    'is_active' => true,
                ]);

                // Queue welcome email with the generated password
                Mail::to($email)->queue(new UserWelcomeMail($newUser, $userPassword));

                $created++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }

        fclose($handle);

        $message = "Import complete: {$created} users created, {$skipped} skipped.";
        if (!empty($errors)) {
            $message .= ' Details: ' . implode(' ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $message .= ' (and ' . (count($errors) - 5) . ' more...)';
            }
        }

        return redirect()->route('school.users.index')->with('success', $message);
    }

    public function downloadTemplate()
    {
        $this->authorizeManager();
        $headers = ['first_name', 'last_name', 'email', 'role', 'class_name', 'section_name', 'parent_email'];
        $callback = function () use ($headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            fputcsv($handle, ['John', 'Doe', 'john.doe@school.com', 'student', 'JSS 1', 'A', 'parent.doe@email.com']);
            fputcsv($handle, ['Jane', 'Smith', 'jane.smith@school.com', 'teacher', '', '', '']);
            fclose($handle);
        };

        return response()->streamDownload($callback, 'users-import-template.csv', [
            'Content-Type' => 'text/csv',
        ]);
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