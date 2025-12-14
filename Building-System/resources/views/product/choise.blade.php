<x-layout title="Choose">

    <div class="choice">
        <h1>Choose Product Type</h1>
        @foreach ($types as $type)
        <a href="{{ route('products.byType', ['type' => $type]) }}">GET ALL {{strtoupper($type)}}</a>
        @endforeach
    </div>

</x-layout>