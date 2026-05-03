<x-layout>
    <div class="builder-container">
        <div class="builder-header">
            <h1 class="builder-title">PC Builder</h1>
            <p class="builder-subtitle">Select components for your custom build</p>
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
                                {{ ucfirst(str_replace('-', ' ', $category)) }}
                            </a>
                        </td>
                        <td>
                            @if($products->has($category))
                            @foreach($products[$category] as $product)
                            <div class="selected-product">
                                <strong class="product-name">{{ $product->name }}</strong>
                            </div>
                            @endforeach

                            @if(in_array($category, config('builder.multiple_allowed')))
                            <a href="{{ route('components.index', ['category' => $category]) }}" class="btn">
                                + Add another {{ ucfirst(str_replace('-', ' ', $category)) }}
                            </a>
                            @endif
                            @else
                            <a href="{{ route('components.index', ['category' => $category]) }}" class="check-link">
                                + Add {{ ucfirst(str_replace('-', ' ', $category)) }}
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