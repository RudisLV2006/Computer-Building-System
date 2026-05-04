<x-layout title="Choose Component">
    <div class="builder-header">
        <h1 class="builder-title">Choose Product Type</h1>
        <p class="builder-subtitle">Select a category to browse available components.</p>
    </div>

    <div class="category-grid">
        @foreach ($categories as $category)
        <a href="{{ route('components.index', ['category' => $category]) }}" class="category-card">
            <span class="category-icon">📦</span>
            <span class="category-name">{{ str_replace('-', ' ', $category) }}</span>
            <span class="category-action">Browse All →</span>
        </a>
        @endforeach
    </div>
</x-layout>