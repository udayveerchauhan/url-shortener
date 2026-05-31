@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Invitation Queue</h1>
            <p class="text-sm text-slate-600 mt-2">Manage invited users and their company assignments.</p>
        </div>
        <a href="{{ route('invitations.create') }}" class="rounded-md bg-sky-600 px-4 py-2 text-white hover:bg-sky-700 transition shadow-sm">+ Invite user</a>
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-gradient-to-r from-slate-50 to-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Name</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Role</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Company</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Created</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($invitedUsers as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @foreach($user->roles as $role)
                                <span class="inline-block bg-sky-100 text-sky-800 text-xs px-2 py-1 rounded">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">{{ $user->company?->name ?? 'None' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292m-7.08 2.428a7 7 0 1414.16 0M9 9h.01M15 9h.01"></path>
                                </svg>
                                <p class="text-slate-500 font-medium">No invited users found.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $invitedUsers->links() }}
</div>
@endsection
