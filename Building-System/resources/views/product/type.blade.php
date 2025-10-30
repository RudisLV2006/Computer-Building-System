<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    @vite('resources/css/app.css')

</head>
<body>
    <a href="{{ route('product.choise') }}" class="back">← Back to Product Types</a>

    <h1>Available Products</h1>

    <div class="product-list">
        @foreach ($products as $spec)
            <div class="product-item">
                <p class="product-name">{{ $spec->product->name }}</p>
                <a href="{{ route('product.view', ['type' => $type, 'spec' => $spec->id]) }}" class="check-link">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
</body>
</html>
