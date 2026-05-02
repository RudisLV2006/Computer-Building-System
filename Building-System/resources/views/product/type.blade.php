<x-layout title="All product by type">
    <a href="{{ route('components.choose') }}" class="back">← Back to Product Components</a>
    <a href="{{ route('builder.debug') }}" class="back">Debug</a>

    <h1>Available Products</h1>

    <div class="product-list">
        @foreach ($items as $item)
        <div class="product-item">
            <p class="product-name">{{ ucfirst($item->product->name) }}</p>
            <a href="{{ route('components.show', ['category' => $category, 'product' => $item]) }}" class="check-link">
                View Details
            </a>
            <form action="{{route('builder.store', ['category' => $category, 'product' => $item])}}" method="post">
                @csrf
                <button>Add</button>
            </form>
        </div>
        @endforeach
    </div>
</x-layout>