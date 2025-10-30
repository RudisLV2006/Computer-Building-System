<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choice</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="choice">
        <h1>Choose Product Type</h1>
        <a href="{{ route('products.byType', ['type' => 'mobo']) }}">Get all Motherboards</a>
        <a href="{{ route('products.byType', ['type' => 'gpu']) }}">Get all GPUs</a>
        <a href="{{ route('products.byType', ['type' => 'cpu']) }}">Get all CPUs</a>
    </div>
</body>
</html>
