@extends('layouts.school')

@section('title', 'Edit Book')

@section('content')
    <div class="animate-fade-up">
        <a href="{{ route('school.library.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-brand-600 transition mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Back to Library
        </a>

        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-900">Edit Book</h1>
            <p class="text-sm text-slate-400 mt-0.5">Update book information</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 max-w-2xl">
            <form method="POST" action="{{ route('school.library.update', $book) }}">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">Title <span class="text-red-400">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                        @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="author" class="block text-sm font-semibold text-slate-700 mb-1.5">Author</label>
                            <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('author')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="isbn" class="block text-sm font-semibold text-slate-700 mb-1.5">ISBN</label>
                            <input type="text" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('isbn')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="category" class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
                            <input type="text" id="category" name="category" value="{{ old('category', $book->category) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="publisher" class="block text-sm font-semibold text-slate-700 mb-1.5">Publisher</label>
                            <input type="text" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('publisher')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div>
                            <label for="edition" class="block text-sm font-semibold text-slate-700 mb-1.5">Edition</label>
                            <input type="text" id="edition" name="edition" value="{{ old('edition', $book->edition) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('edition')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="quantity" class="block text-sm font-semibold text-slate-700 mb-1.5">Quantity <span class="text-red-400">*</span></label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $book->quantity) }}" min="1" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="shelf_location" class="block text-sm font-semibold text-slate-700 mb-1.5">Shelf Location</label>
                            <input type="text" id="shelf_location" name="shelf_location" value="{{ old('shelf_location', $book->shelf_location) }}" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            @error('shelf_location')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-1.5">Status <span class="text-red-400">*</span></label>
                        <select id="status" name="status" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">
                            <option value="available" {{ old('status', $book->status) === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="lost" {{ old('status', $book->status) === 'lost' ? 'selected' : '' }}>Lost</option>
                            <option value="damaged" {{ old('status', $book->status) === 'damaged' ? 'selected' : '' }}>Damaged</option>
                        </select>
                        @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-4 py-2.5 bg-gray-50/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-500/10 transition">{{ old('description', $book->description) }}</textarea>
                        @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg shadow-brand-600/20 hover:shadow-brand-600/30 transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Update Book
                    </button>
                    <a href="{{ route('school.library.index') }}" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
