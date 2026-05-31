<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-6">
        <header class="mb-8 border-b border-slate-200 pb-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-sky-600">URL Shortener</a>

                <nav class="flex items-center space-x-6 text-sm font-medium">
                    @auth
                        <div class="flex items-center space-x-4">
                            <div class="text-slate-600">
                                <span class="text-slate-900 font-medium">{{ auth()->user()->name }}</span>
                                <span class="text-slate-500 mx-1">·</span>
                                <span class="text-xs bg-sky-100 text-sky-800 px-2 py-1 rounded">{{ auth()->user()->roles->pluck('name')->join(', ') }}</span>
                            </div>
                        </div>
                        @if(auth()->user()->hasRole('SuperAdmin'))
                            <a href="{{ route('invitations.index') }}" class="text-slate-700 hover:text-slate-900 hover:font-semibold transition">Invitations</a>
                            <a href="{{ route('short-urls.index') }}" class="text-slate-700 hover:text-slate-900 hover:font-semibold transition">Short URLs</a>
                        @else
                            <a href="{{ route('short-urls.index') }}" class="text-slate-700 hover:text-slate-900 hover:font-semibold transition">Short URLs</a>
                            @if(auth()->user()->hasRole('Admin'))
                                <a href="{{ route('invitations.index') }}" class="text-slate-700 hover:text-slate-900 hover:font-semibold transition">Invitations</a>
                            @endif
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-700 hover:text-slate-900 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-700 hover:text-slate-900">Login</a>
                    @endauth
                </nav>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 p-4 text-rose-800">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
