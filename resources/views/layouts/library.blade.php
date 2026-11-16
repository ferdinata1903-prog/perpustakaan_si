<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Library SI - @yield('title')</title>
    @vite('resources/css/library.css')
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || (performance.getEntriesByType("navigation")[0]?.type === "back_forward")) {
                window.location.reload();
            }
        });
    </script>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>📚 Library SI</h1>
            <p>Temukan bacaan favoritmu di sini</p>
        </div>
    </header>

    <nav class="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">Daftar Buku</a>
        @can('kelola data buku')
        <a href="{{ route('buku.kelola') }}" class="{{ request()->routeIs('buku.kelola') ? 'active' : '' }}">Kelola Buku</a>
        @endcan

        <div class="nav-auth">
            @auth
                <span class="nav-user">{{ Auth::user()->name }}</span>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-logout-btn">Logout</button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
        </div>
    </div>
    </nav>

    <main class="konten container">
        @yield('content')
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} Library SI
    </footer>
@yield('scripts')
</body>
</html>