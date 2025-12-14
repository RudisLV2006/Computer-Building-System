<x-layout>
    <div class="builder-container">
        <div class="builder-header">
            <h1 class="builder-title">PC Builder</h1>
            <p class="builder-subtitle">Select components for your custom build</p>

            @if(Session('incompacting'))
            @foreach($messages as $message)
            @endforeach
            @endif

        </div>

        <div class="builder-table">
            <table>
                <thead>
                    <tr>
                        <th>Component</th>
                        <th>Selection</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                    <tr>
                        <td>
                            <a href="{{ route('products.byType', ['type' => $type]) }}" class="part-name-link">
                                {{ ucfirst($type) }}
                            </a>
                        </td>
                        <td>
                            @if($type === 'ram' && $cart->hasItem('ram'))
                            <div class="selected-product">
                                @foreach($cart->getProduct('ram') as $ram)
                                <strong class="product-name">{{ $ram['name'] }}</strong>
                                @endforeach

                                <a href="{{ route('products.byType', ['type' => 'ram']) }}"
                                    class="check-link">
                                    + Add another RAM
                                </a>
                            </div>
                            @elseif($cart->hasItem($type))
                            <strong class="product-name">
                                {{ $cart->getProduct($type)['name'] }}
                            </strong>
                            @else
                            <a href="{{ route('products.byType', ['type' => $type]) }}"
                                class="check-link">
                                + Add {{ ucfirst($type) }}
                            </a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>