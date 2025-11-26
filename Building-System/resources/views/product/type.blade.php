<x-layout title="All product by type">
    <a href="{{ route('products.index') }}" class="back">← Back to Product Types</a>

    <h1>Available Products</h1>

    <div class="product-list">

        @foreach ($items as $item)
            <div class="product-item">
                <p class="product-name">{{ $item->product->name }}</p>
                <a href="{{ route('products.showSpec', ['type' => $type, 'item' => $item->product_id]) }}" class="check-link">
                    View Details
                </a>
                <a href="{{ route('builder.addItem', ['type' => $type, 'item' => $item->product_id]) }}" class="check-link">
                    Add
                </a>
            </div>
        @endforeach
    </div>
</x-layout>