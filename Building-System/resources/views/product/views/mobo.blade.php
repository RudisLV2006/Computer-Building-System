<x-layout title="Check product specs">
    <a href="{{ route('products.byType', $type) }}" class="back">← Back to Motherboards</a>
    
    <div class="product-view motherboard-view">
        <div class="product-header">
            <h1>{{ $product->name }}</h1>
            <span class="product-type">Motherboard</span>
        </div>
        
        <div class="product-content">
            <div class="product-image">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}">
            </div>
            
            <div class="product-details">
                <h2>Specifications</h2>
                <table>
                    <tr>
                        <th>Socket</th>
                        <td>{{ $spec->socket }}</td>
                    </tr>
                    <tr>
                        <th>Chipset</th>
                        <td>{{ $spec->chipset }}</td>
                    </tr>
                    <tr>
                        <th>Form Factor</th>
                        <td>{{ $spec->form_factor }}</td>
                    </tr>
                    <tr>
                        <th>Memory Type</th>
                        <td>{{ $spec->memory_technology }}</td>
                    </tr>
                </table>
                
            </div>
        </div>
    </div>
</x-layout>