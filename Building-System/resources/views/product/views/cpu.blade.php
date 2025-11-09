<x-layout>
    <a href="{{ route('products.byType', $type) }}" class="back">← Back to CPU</a>

    <div class="product-view cpu-view">
        <div class="product-header">
            <h1>{{ $product->name }}</h1>
            <span class="product-type">Processor</span>
        </div>
        
        <div class="product-content">
            <div class="product-image">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}">
            </div>
            
            <div class="product-details">
                <h2>Specifications</h2>
                <table>
                    <tr>
                        <td>Socket</td>
                        <td>{{ $spec->socket }}</td>
                    </tr>
                    <tr>
                        <td>Base Clock</td>
                        <td>{{ $spec->cpu_speed_ghz }} GHz</td>
                    </tr>
                    <tr>
                        <td>TDP</td>
                        <td>{{ $spec->wattage_w }}W</td>
                    </tr>
                    <tr>
                        <td>Integrated Graphics</td>
                        <td>{{ $spec->integrated_graphics ?? 'No' }}</td>
                    </tr>
                </table>
                
            </div>
        </div>
    </div>
</x-layout>