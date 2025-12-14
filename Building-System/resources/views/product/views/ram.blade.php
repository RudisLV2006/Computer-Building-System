<x-layout title="Check RAM specs">
    <a href="{{ route('products.byType', $type) }}" class="back">← Back to RAM</a>

    <div class="product-view">
        <div class="product-header">
            <h1>{{ $product->name }}</h1>
            <span class="product-type">Memory (RAM)</span>
        </div>

        <div class="product-content">
            <div class="product-image">
                <img
                    src="{{ $product->image ?? 'https://placehold.co/300?text=' . urlencode($product->name) }}"
                    alt="{{ $product->name }}">
            </div>

            <div class="product-details">
                <h2>Specifications</h2>

                <table>
                    <tr>
                        <td>Manufacturer</td>
                        <td>{{ $item->manufacturer }}</td>
                    </tr>

                    <tr>
                        <td>Series</td>
                        <td>{{ $item->series }}</td>
                    </tr>

                    <tr>
                        <td>Memory Type</td>
                        <td>{{ strtoupper($item->memory_type) }}</td>
                    </tr>

                    <tr>
                        <td>Total Capacity</td>
                        <td>{{ $item->capacity_gb }} GB</td>
                    </tr>

                    <tr>
                        <td>Modules</td>
                        <td>{{ $item->modules }} × {{ $item->capacity_gb / $item->modules }} GB</td>
                    </tr>

                    <tr>
                        <td>Speed</td>
                        <td>{{ $item->speed_mhz }} MHz</td>
                    </tr>

                    @if($item->base_speed_mhz)
                    <tr>
                        <td>Base Speed</td>
                        <td>{{ $item->base_speed_mhz }} MHz</td>
                    </tr>
                    @endif

                    <tr>
                        <td>CAS Latency</td>
                        <td>CL{{ $item->cas_latency }}</td>
                    </tr>

                    <tr>
                        <td>Voltage</td>
                        <td>{{ $item->voltage_v }} V</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</x-layout>