@props(['title'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My App' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav>
        <a href="{{route('components.choose')}}">Products</a> |
        <a href="{{route('builder.index')}}">Builder</a> |
        @auth
        <a href="{{ route('profile.edit') }}">{{ Auth::user()->name }}</a> |
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
        </form>
        @else
        <a href="{{ route('login') }}">Login</a> |
        <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>

    @if (Session('error'))
    <p class="text-danger">{{ session('error') }}</p>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer>
        <p>Will be implemented</p>
    </footer>
</body>

</html>