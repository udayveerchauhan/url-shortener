@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="rounded-lg bg-white p-8 shadow">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Create Short URL</h1>
        <p class="text-slate-600 mb-8">Generate a new short URL for easy sharing.</p>

        <form method="POST" action="{{ route('short-urls.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="original_url" class="block text-sm font-semibold text-slate-700 mb-2">Original URL</label>
                <input 
                    id="original_url" 
                    name="original_url" 
                    type="url" 
                    value="{{ old('original_url') }}" 
                    placeholder="https://example.com/very/long/url"
                    required 
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition" 
                />
                @error('original_url')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="rounded-md bg-sky-600 px-6 py-2 text-white hover:bg-sky-700 transition shadow-sm font-medium"
                >
                    Create Short URL
                </button>
                <a 
                    href="{{ route('short-urls.index') }}" 
                    class="rounded-md bg-slate-200 px-6 py-2 text-slate-900 hover:bg-slate-300 transition font-medium"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
