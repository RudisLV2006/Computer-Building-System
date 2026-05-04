<x-layout title="Available {{ ucfirst($category) }}">
    <div class="action-bar">
        <a href="{{ route('components.choose') }}" class="back">← Back to Categories</a>
        <a href="{{ route('builder.debug') }}" class="debug-pill">Debug Mode</a>
    </div>

    <div class="builder-header">
        <h1 class="builder-title">Available {{ ucfirst(str_replace('-', ' ', $category)) }}</h1>
    </div>

    <div class="product-list-container">
        @foreach ($items as $item)
        <div class="product-item-row">
            <div class="product-info-main">
                <p class="product-name-large">{{ ucfirst($item->product->name) }}</p>
                <span class="product-id-badge">ID: {{ $item->product_id }}</span>
            </div>

            <div class="product-item-actions">
                <a href="{{ route('components.show', ['category' => $category, 'product' => $item]) }}" class="btn-secondary">
                    View Details
                </a>
                <form action="{{route('builder.storeItem', ['category' => $category, 'product' => $item])}}" method="post">
                    @csrf
                    <button type="submit" class="btn-success">Add to Build</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagination-wrapper">
        {{ $items->links() }}
    </div>
</x-layout>