@extends('layouts.school')

@section('title', 'Library')

@section('content')
    <div class="animate-fade-up">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Library</h1>
                <p class="text-sm text-slate-500 mt-1">Manage books and track lending</p>
            </div>
            @if($tab === 'books')
            <a href="{{ route('school.library.create') }}" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Add Book
            </a>
            @endif
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['total_titles'] }}</p>
                        <p class="text-xs text-slate-400 font-medium">Book Titles</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.75h-4.5a2.25 2.25 0 00-2.25 2.25v4.5m0 0L8.25 18.75M10.5 9.75l8.25 8.25M3 6.75h4.5a2.25 2.25 0 012.25 2.25v4.5"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['total_books'] }}</p>
                        <p class="text-xs text-slate-400 font-medium">Total Copies</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['issued'] }}</p>
                        <p class="text-xs text-slate-400 font-medium">Issued Out</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['overdue'] }}</p>
                        <p class="text-xs text-slate-400 font-medium">Overdue</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex items-center gap-2 mb-6">
            <a href="{{ route('school.library.index', ['tab' => 'books'] + request()->except('tab', 'page', 'issue_status')) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $tab === 'books' ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'bg-white text-slate-500 border border-gray-200 hover:bg-gray-50' }}">
                All Books
            </a>
            <a href="{{ route('school.library.index', ['tab' => 'issued'] + request()->except('tab', 'page', 'category', 'status')) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $tab === 'issued' ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'bg-white text-slate-500 border border-gray-200 hover:bg-gray-50' }}">
                Issued Books
                @if($stats['issued'] > 0)
                <span class="ml-1.5 px-1.5 py-0.5 rounded-full text-[10px] {{ $tab === 'issued' ? 'bg-white/20' : 'bg-amber-50 text-amber-600' }}">{{ $stats['issued'] }}</span>
                @endif
            </a>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Search Bar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $tab === 'books' ? 'Search by title, author, ISBN...' : 'Search by book or student...' }}" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 focus:bg-white transition">
                </div>
                @if($tab === 'books' && $categories->isNotEmpty())
                <select name="category" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @endif
                @if($tab === 'books')
                <select name="status" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
                    <option value="damaged" {{ request('status') === 'damaged' ? 'selected' : '' }}>Damaged</option>
                </select>
                @else
                <select name="issue_status" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-brand-400 transition">
                    <option value="">All Status</option>
                    <option value="issued" {{ request('issue_status') === 'issued' ? 'selected' : '' }}>Issued</option>
                    <option value="returned" {{ request('issue_status') === 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
                @endif
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    Search
                </button>
            </form>
        </div>

        {{-- Books Tab --}}
        @if($tab === 'books')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Title</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Author</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Category</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Copies</th>
                            <th class="text-center py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Available</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($books as $book)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3 px-4">
                                <div class="font-medium text-gray-800">{{ $book->title }}</div>
                                @if($book->isbn)
                                    <div class="text-xs text-slate-400">ISBN: {{ $book->isbn }}</div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $book->author ?? '—' }}</td>
                            <td class="py-3 px-4 text-gray-600">
                                @if($book->category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-brand-50 text-brand-600 text-xs font-medium">{{ $book->category }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center font-medium text-gray-700">{{ $book->quantity }}</td>
                            <td class="py-3 px-4 text-center">
                                @php $available = $book->quantity - $book->active_issues_count; @endphp
                                <span class="font-semibold {{ $available > 0 ? 'text-emerald-600' : 'text-red-500' }}">{{ $available }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($book->status === 'available')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-medium">Available</span>
                                @elseif($book->status === 'lost')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-50 text-red-600 text-xs font-medium">Lost</span>
                                @elseif($book->status === 'damaged')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-xs font-medium">Damaged</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($available > 0)
                                    <a href="{{ route('school.library.issueForm', $book) }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium">Issue</a>
                                    @endif
                                    <a href="{{ route('school.library.edit', $book) }}" class="text-brand-600 hover:text-brand-700 text-xs font-medium">Edit</a>
                                    <form method="POST" action="{{ route('school.library.destroy', $book) }}" onsubmit="return confirm('Remove this book from the library?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No books in the library yet</p>
                                    <p class="text-xs text-slate-400 mt-1">Get started by adding a new book.</p>
                                    <a href="{{ route('school.library.create') }}" class="mt-4 inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-4 py-2 rounded-xl text-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                        Add Book
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($books->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $books->withQueryString()->links() }}</div>
            @endif
        </div>
        @endif

        {{-- Issued Books Tab --}}
        @if($tab === 'issued')
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Book</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Student</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Issue Date</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Due Date</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Return Date</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-slate-500 uppercase tracking-wider text-xs">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($issues as $issue)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3 px-4">
                                <div class="font-medium text-gray-800">{{ $issue->book->title }}</div>
                                <div class="text-xs text-slate-400">{{ $issue->book->author ?? '' }}</div>
                            </td>
                            <td class="py-3 px-4 text-gray-600">{{ $issue->user->full_name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $issue->issue_date->format('d M, Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="{{ $issue->is_overdue ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                    {{ $issue->due_date->format('d M, Y') }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-600">
                                {{ $issue->return_date ? $issue->return_date->format('d M, Y') : '—' }}
                            </td>
                            <td class="py-3 px-4">
                                @if($issue->status === 'issued')
                                    @if($issue->is_overdue)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-red-50 text-red-600 text-xs font-medium">Overdue</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-xs font-medium">Issued</span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-medium">Returned</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($issue->status === 'issued')
                                <form method="POST" action="{{ route('school.library.return', $issue) }}" onsubmit="return confirm('Mark this book as returned?')">
                                    @csrf
                                    <button type="submit" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium">Return Book</button>
                                </form>
                                @else
                                <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-2xl p-4 mb-3">
                                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-400">No issued books</p>
                                    <p class="text-xs text-slate-400 mt-1">Books issued to students will appear here.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($issues->hasPages())
            <div class="p-4 border-t border-gray-100">{{ $issues->withQueryString()->links() }}</div>
            @endif
        </div>
        @endif
    </div>
@endsection
