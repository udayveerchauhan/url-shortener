@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Short URLs</h1>
            <p class="text-sm text-slate-600 mt-2">Manage and view short URLs based on your role permissions.</p>
        </div>
        @can('create', App\Models\ShortUrl::class)
            <a href="{{ route('short-urls.create') }}" class="rounded-md bg-sky-600 px-4 py-2 text-white hover:bg-sky-700 transition shadow-sm">+ Create new short URL</a>
        @endcan
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Short Code</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Original URL</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Company</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Created by</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($shortUrls as $shortUrl)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm font-mono text-sky-600 font-semibold"><a href="{{ route('short-urls.redirect', $shortUrl->short_code) }}" target="_blank" rel="noopener noreferrer">{{ $shortUrl->short_code }}</a></td>
                        <td class="px-6 py-4 text-sm text-slate-600 break-words max-w-md">{{ Str::limit($shortUrl->original_url, 50) }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $shortUrl->company->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $shortUrl->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            @can('delete', $shortUrl)
                                <form method="POST" action="{{ route('short-urls.destroy', $shortUrl) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded bg-rose-600 px-3 py-1.5 text-sm text-white hover:bg-rose-700 transition shadow-sm">Delete</button>
                                </form>
                            @else
                                <span class="text-slate-400">—</span>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <p class="text-slate-500 font-medium">No short URLs available.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $shortUrls->links() }}
</div>
@endsection
