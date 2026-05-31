@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto rounded-xl bg-white p-8 shadow-sm">
    <h1 class="mb-6 text-2xl font-semibold text-slate-900">Login</h1>

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" />
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" />
                Remember me
            </label>
        </div>

        <button type="submit" class="w-full rounded-md bg-sky-600 px-4 py-2 text-white hover:bg-sky-700">Login</button>
    </form>
</div>
@endsection
