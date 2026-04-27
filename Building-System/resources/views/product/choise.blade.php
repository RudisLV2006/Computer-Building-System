<x-layout title="Choose">

    <div class="choice">
        <h1>Choose Product Type</h1>
        @foreach ($categories as $category)
        <a href="{{ route('components.index', ['category' => $category]) }}">GET ALL {{strtoupper($category)}}</a>
        @endforeach
    </div>

</x-layout>