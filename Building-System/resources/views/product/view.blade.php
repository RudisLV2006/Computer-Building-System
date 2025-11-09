<x-layout title="Check product specs">
    <a href="{{ route('products.byType', ['type' => $type]) }}" class="back">← Back to {{ ucfirst($type) }} List</a>

    <h1>{{ $product->name }}</h1>

    <h2>Motherboard Specs</h2>
    <table>
        <tr><th>Specification</th><th>Details</th></tr>
        <tr><td>Manufacturer</td><td>{{ $spec->manufacturer }}</td></tr>
        <tr><td>Series</td><td>{{ $spec->series }}</td></tr>
        <tr><td>Socket</td><td>{{ $spec->socket }}</td></tr>
        <tr><td>Chipset</td><td>{{ $spec->chipset }}</td></tr>
        <tr><td>Memory Technology</td><td>{{ $spec->memory_technology }}</td></tr>
        <tr><td>Form Factor</td><td>{{ $spec->form_factor }}</td></tr>
    </table>
</x-layout>