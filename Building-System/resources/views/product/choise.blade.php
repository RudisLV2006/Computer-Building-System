<x-layout title="Choose">

    <div class="choice">
        <h1>Choose Product Type</h1>
        <a href="{{ route('products.byType', ['type' => 'cpu']) }}">Get all CPUs</a>
        <a href="{{ route('products.byType', ['type' => 'mobo']) }}">Get all Motherboards</a>
        <a href="{{ route('products.byType', ['type' => 'gpu']) }}">Get all GPUs</a>
    </div>

</x-layout>