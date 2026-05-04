<x-layout>
    <div class="builder-container">

        {{-- SAVE FORM --}}
        <div class="builder-header">
            <h1 class="builder-title">Save Build</h1>

            <form action="{{ route('builder.save') }}" method="POST">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label for="name">Build Name</label>
                    <input type="text" name="name" id="name" required placeholder="Enter build name">
                </div>

                {{-- Pass selected products --}}
                @foreach($products as $category => $items)
                @foreach($items as $item)
                <input type="hidden"
                    name="products[{{ $category }}][{{ $loop->index }}][id]"
                    value="{{ $item['product']->id }}">

                <input type="hidden"
                    name="products[{{ $category }}][{{ $loop->index }}][count]"
                    value="{{ $item['count'] }}">
                @endforeach
                @endforeach

                <button type="submit">Save Build</button>
            </form>
        </div>

        {{-- YOUR EXISTING BUILDER --}}
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
                            @foreach($products[$category] as $item)
                            <div class="selected-product">
                                <strong class="product-name">{{ $item['product']->name }}</strong>

                                @if($item['count'] > 1)
                                <span>x{{ $item['count'] }}</span>
                                @endif

                                <form action="{{ route('builder.remove', ['category' => $category, 'product' => $item['product']->id]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button>delete</button>
                                </form>
                            </div>
                            @endforeach
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