<x-layout title="Check mobo specs">
    <a href="{{ route('products.byType', $type) }}" class="back">← Back to Motherboards</a>
    
    <div class="product-view">
        <div class="product-header">
            <h1>{{ $product->name }}</h1>
            <span class="product-type">Motherboard</span>
        </div>
        
        <div class="product-content">
            <div class="product-image">
                <img src="{{$product->image ?? 'https://placehold.co/300?text=' . urlencode($product->name) }}">
            </div>
            
            <div class="product-details">
                <h2>Specifications</h2>
                <table>
                    <tr>
                        <th>Socket</th>
                        <td>{{ $item->socket }}</td>
                    </tr>
                    <tr>
                        <th>Chipset</th>
                        <td>{{ $item->chipset }}</td>
                    </tr>
                    <tr>
                        <th>Form Factor</th>
                        <td>{{ $item->form_factor }}</td>
                    </tr>
                    <tr>
                        <th>Memory Type</th>
                        <td>{{ $item->memory_technology }}</td>
                    </tr>
                </table>
                
            </div>
        </div>
    </div>
</x-layout>