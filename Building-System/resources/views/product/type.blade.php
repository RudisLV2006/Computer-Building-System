<x-layout title="All product by type">
    <a href="{{ route('products.index') }}" class="back">← Back to Product Types</a>

    <h1>Available Products</h1>

    <div class="product-list">
        @foreach ($products as $spec)
            <div class="product-item">
                <p class="product-name">{{ $spec->product->name }}</p>
                <a href="{{ route('products.showSpec', ['type' => $type, 'spec' => $spec->product_id]) }}" class="check-link">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
</x-layout>