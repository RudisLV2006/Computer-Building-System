<x-layout title="Check cpu specs">
    <a href="{{ route('components.index', $category) }}" class="back">← Back to CPU</a>

    <div class="product-view">
        <div class="product-header">
            <h1>{{ $item->product->name }}</h1>
            <span class="product-type">Processor</span>
        </div>

        <div class="product-content">
            <div class="product-image">
                <img src="{{$product->image ?? 'https://placehold.co/300?text=' . urlencode($item->product->name) }}">
            </div>

            <div class="product-details">
                <h2>Specifications</h2>
                <table>
                    <tr>
                        <td>Socket</td>
                        <td>{{ $item->socket }}</td>
                    </tr>
                    <tr>
                        <td>Base Clock</td>
                        <td>{{ $item->cpu_speed_ghz }} GHz</td>
                    </tr>
                    <tr>
                        <td>TDP</td>
                        <td>{{ $item->wattage_w }}W</td>
                    </tr>
                    <tr>
                        <td>Integrated Graphics</td>
                        <td>{{ $item->integrated_graphics ?? 'No' }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</x-layout>