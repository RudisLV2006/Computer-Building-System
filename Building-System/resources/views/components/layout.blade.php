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
    @if (Session('error'))
        <p class="text-danger">{{ session('error') }}</p>
    @endif
    
    <nav>
        <a href="{{route('products.index')}}">Products</a> |
        <a href="{{route('builder.index')}}">Builder</a>    
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <p>Will be implemented</p>
    </footer>
</body>
</html>
