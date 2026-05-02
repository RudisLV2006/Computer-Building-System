@props(['title', 'category', 'item'])

<x-layout :title="$title">
    <a href="{{ route('components.index', $category) }}" class="back">← Back to {{ ucfirst(str_replace('-', ' ', $category)) }}</a>

    <div class="product-view">
        <div class="product-header">
            <h1>{{ ucfirst($item->product->name) }}</h1>
            {{ $type }}
        </div>

        <div class="product-content">
            <div class="product-image">
                <img src="{{'https://placehold.co/300?text=' . urlencode($item->product->name) }}">
            </div>

            <div class="product-details">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-layout>