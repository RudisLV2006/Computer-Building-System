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
                                @if($cart->hasItem($type))
                                    <div class="selected-product">
                                        <strong class="product-name">{{ $cart->getProduct($type)["name"] }}</strong>
                                    </div>
                                @else
                                    <span class="not-selected">Not selected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>