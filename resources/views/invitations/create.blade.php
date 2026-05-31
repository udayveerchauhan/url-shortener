@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="rounded-lg bg-white p-8 shadow">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Invite a new user</h1>
        <p class="text-slate-600 mb-8">Create a new user account and assign them to a company with a specific role.</p>

        <form method="POST" action="{{ route('invitations.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                <input 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required 
                    placeholder="John Doe"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition" 
                />
                @error('name')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    value="{{ old('email') }}" 
                    required 
                    placeholder="john@example.com"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition" 
                />
                @error('email')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition" 
                    />
                    @error('password')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        required 
                        placeholder="••••••••"
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition" 
                    />
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-2">Role</label>
                    <select 
                        id="role" 
                        name="role" 
                        required 
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition"
                    >
                        <option value="">Select a role...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="company_id" class="block text-sm font-semibold text-slate-700 mb-2">Company</label>
                    <select 
                        id="company_id" 
                        name="company_id" 
                        required 
                        class="w-full rounded-md border border-slate-300 px-3 py-2 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition"
                    >
                        <option value="">Select a company...</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-6">
                <button 
                    type="submit" 
                    class="rounded-md bg-sky-600 px-6 py-2 text-white hover:bg-sky-700 transition shadow-sm font-medium"
                >
                    Send Invitation
                </button>
                <a 
                    href="{{ route('invitations.index') }}" 
                    class="rounded-md bg-slate-200 px-6 py-2 text-slate-900 hover:bg-slate-300 transition font-medium"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
