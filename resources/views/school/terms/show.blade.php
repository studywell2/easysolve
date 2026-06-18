@extends('layouts.school')

@section('title', 'Terms & Conditions')

@section('content')
    <div class="max-w-3xl mx-auto animate-fade-up">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-br from-brand-600 to-indigo-700 px-6 py-5">
                <h1 class="text-xl font-bold text-white">Terms & Conditions</h1>
                <p class="text-brand-200/80 text-sm mt-0.5">{{ $school->name }}</p>
                @if($school->terms_updated_at)
                    <p class="text-brand-200/60 text-xs mt-1">Last updated: {{ $school->terms_updated_at->format('F j, Y') }}</p>
                @endif
            </div>

            <!-- Terms Content -->
            <div class="p-6 max-h-[60vh] overflow-y-auto prose prose-sm prose-slate max-w-none">
                {!! nl2br(e($school->terms_and_conditions)) !!}
            </div>

            <!-- Acceptance Form -->
            <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-5">
                <form method="POST" action="{{ route('school.terms.accept') }}">
                    @csrf

                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="accepted" value="1" id="terms_accepted"
                            class="mt-0.5 w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500 transition">
                        <span class="text-sm text-slate-600">
                            I have read and agree to the <strong class="text-slate-800">Terms & Conditions</strong> of <strong class="text-slate-800">{{ $school->name }}</strong>.
                        </span>
                    </label>
                    @error('accepted')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                    <div class="mt-5 flex items-center gap-3">
                        <button type="submit" id="accept-btn" disabled
                            class="px-6 py-2.5 bg-brand-600 text-white text-sm font-medium rounded-xl hover:bg-brand-700 transition disabled:opacity-40 disabled:cursor-not-allowed">
                            Accept & Continue
                        </button>
                        <span class="text-xs text-slate-400">You must accept the terms to continue using the portal.</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('terms_accepted').addEventListener('change', function() {
            document.getElementById('accept-btn').disabled = !this.checked;
        });
    </script>
@endsection
