<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use App\Models\LibraryBook;
use App\Models\User;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeManager();
        $schoolId = auth()->user()->school_id;
        $tab = $request->get('tab', 'books');

        if ($tab === 'issued') {
            return $this->issuedBooks($request, $schoolId);
        }

        $query = LibraryBook::where('school_id', $schoolId)->withCount(['activeIssues']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $books = $query->latest()->paginate(15)->appends($request->query());
        $categories = LibraryBook::where('school_id', $schoolId)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $stats = [
            'total_books' => LibraryBook::where('school_id', $schoolId)->sum('quantity'),
            'total_titles' => LibraryBook::where('school_id', $schoolId)->count(),
            'issued' => BookIssue::where('school_id', $schoolId)->where('status', 'issued')->count(),
            'overdue' => BookIssue::where('school_id', $schoolId)->where('status', 'issued')->where('due_date', '<', now()->toDateString())->count(),
        ];

        return view('school.library.index', compact('books', 'categories', 'stats', 'tab'));
    }

    private function issuedBooks(Request $request, $schoolId)
    {
        $query = BookIssue::where('school_id', $schoolId)
            ->with(['book', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('issue_status')) {
            $query->where('status', $request->issue_status);
        }

        $issues = $query->latest()->paginate(15)->appends($request->query());

        $stats = [
            'total_books' => LibraryBook::where('school_id', $schoolId)->sum('quantity'),
            'total_titles' => LibraryBook::where('school_id', $schoolId)->count(),
            'issued' => BookIssue::where('school_id', $schoolId)->where('status', 'issued')->count(),
            'overdue' => BookIssue::where('school_id', $schoolId)->where('status', 'issued')->where('due_date', '<', now()->toDateString())->count(),
        ];

        $categories = collect();

        return view('school.library.index', compact('issues', 'stats', 'tab', 'categories'));
    }

    public function create()
    {
        $this->authorizeManager();
        return view('school.library.create');
    }

    public function store(Request $request)
    {
        $this->authorizeManager();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:available,lost,damaged',
        ]);

        LibraryBook::create([
            ...$validated,
            'school_id' => auth()->user()->school_id,
        ]);

        return redirect()->route('school.library.index')->with('success', 'Book added to library successfully.');
    }

    public function edit(LibraryBook $library)
    {
        $this->authorizeAccess($library);
        $this->authorizeManager();

        $book = $library;
        return view('school.library.edit', compact('book'));
    }

    public function update(Request $request, LibraryBook $library)
    {
        $this->authorizeAccess($library);
        $this->authorizeManager();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'publisher' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:available,lost,damaged',
        ]);

        $library->update($validated);

        return redirect()->route('school.library.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(LibraryBook $library)
    {
        $this->authorizeAccess($library);
        $this->authorizeManager();

        $activeIssues = $library->activeIssues()->count();
        if ($activeIssues > 0) {
            return back()->with('error', "Cannot delete: {$activeIssues} copies are currently issued.");
        }

        $library->delete();

        return redirect()->route('school.library.index')->with('success', 'Book removed from library.');
    }

    // ─── Book Lending ───────────────────────────────────

    public function issueForm(LibraryBook $library)
    {
        $this->authorizeAccess($library);
        $this->authorizeManager();

        $book = $library;
        $students = User::where('school_id', auth()->user()->school_id)
            ->where('role', 'student')
            ->where('is_active', true)
            ->orderBy('first_name')
            ->get();

        return view('school.library.issue', compact('book', 'students'));
    }

    public function issue(Request $request, LibraryBook $library)
    {
        $this->authorizeAccess($library);
        $this->authorizeManager();

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'notes' => 'nullable|string|max:500',
        ]);

        // Check the student belongs to the same school
        $student = User::where('id', $validated['user_id'])
            ->where('school_id', auth()->user()->school_id)
            ->firstOrFail();

        // Check available copies
        $availableCopies = $library->quantity - $library->activeIssues()->count();
        if ($availableCopies <= 0) {
            return back()->with('error', 'No copies available for issue.')->withInput();
        }

        BookIssue::create([
            'school_id' => auth()->user()->school_id,
            'library_book_id' => $library->id,
            'user_id' => $validated['user_id'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'status' => 'issued',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('school.library.index', ['tab' => 'issued'])
            ->with('success', "Book issued to {$student->full_name}.");
    }

    public function returnBook(BookIssue $issue)
    {
        $this->authorizeIssueAccess($issue);
        $this->authorizeManager();

        if ($issue->status !== 'issued') {
            return back()->with('error', 'This book has already been returned.');
        }

        $issue->update([
            'return_date' => now()->toDateString(),
            'status' => 'returned',
        ]);

        return redirect()->route('school.library.index', ['tab' => 'issued'])
            ->with('success', 'Book returned successfully.');
    }

    // ─── Authorization Helpers ──────────────────────────

    private function authorizeAccess(LibraryBook $book): void
    {
        if ($book->school_id !== auth()->user()->school_id) {
            abort(403);
        }
    }

    private function authorizeIssueAccess(BookIssue $issue): void
    {
        if ($issue->school_id !== auth()->user()->school_id) {
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
