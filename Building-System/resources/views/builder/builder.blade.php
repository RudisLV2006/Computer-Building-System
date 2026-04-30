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
                    @foreach($categories as $category)
                    <tr>
                        <td>
                            <a href="{{ route('components.index', ['category' => $category]) }}" class="part-name-link">
                                {{ ucfirst($category) }}
                            </a>
                        </td>
                        <td>
                            @if($cart->hasItem($category))
                            <strong class="product-name">
                                {{ $cart->getProduct($category)['name'] }}
                            </strong>
                            @else
                            <a href="{{ route('components.index', ['category' => $category]) }}"
                                class="check-link">
                                + Add {{ ucfirst($category) }}
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