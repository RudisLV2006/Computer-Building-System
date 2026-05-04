@props(['title'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PC Builder' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav>
        <a href="{{route('components.choose')}}">Products</a>
        <a href="{{route('builder.index')}}">Builder</a>
        <a href="{{route('builder.builds')}}">Community Builds</a>

        <div class="nav-auth">
            @auth
            <a href="{{ route('profile.edit') }}"><strong>{{ Auth::user()->name }}</strong></a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </nav>

    @if (session('error'))
    <div class="alert">{{ session('error') }}</div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} PC Builder App — All Rights Reserved.</p>
    </footer>
</body>

</html>