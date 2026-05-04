<x-layout title="PC Builder">
    <div class="builder-container">
        <div class="builder-header">
            <h1 class="builder-title">PC Builder</h1>
            <p class="builder-subtitle">Select components for your custom build</p>

            @if(!empty($errors))
            <div class="alert">
                @foreach($errors as $message)
                <div>• {{ $message }}</div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="builder-table">
            <table>
                <thead>
                    <tr>
                        <th>Component Category</th>
                        <th>Your Selection</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td width="30%">
                            <strong>{{ ucfirst(str_replace('-', ' ', $category)) }}</strong>
                        </td>
                        <td>
                            @if($products->has($category))
                            @foreach($products[$category] as $item)
                            <div class="selected-product">
                                <div>
                                    <span class="product-name">{{ $item['product']->name }}</span>
                                    @if($item['count'] > 1)
                                    <span class="component-count">x{{ $item['count'] }}</span>
                                    @endif
                                </div>

                                <form action="{{route('builder.remove', ['category' => $category, 'product' => $item['product']->id])}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn-delete">Remove</button>
                                </form>
                            </div>
                            @endforeach

                            @if(in_array($category, config('builder.multiple_allowed')))
                            <a href="{{ route('components.index', ['category' => $category]) }}" class="btn-secondary" style="display:inline-block; font-size: 0.8rem;">
                                + Add another
                            </a>
                            @endif
                            @else
                            <a href="{{ route('components.index', ['category' => $category]) }}" class="btn-secondary">
                                + Choose {{ ucfirst(str_replace('-', ' ', $category)) }}
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <a href="{{ route('builder.save') }}" class="btn-success" style="text-decoration: none; padding: 1rem 2rem;">
                Proceed to Save Build
            </a>
        </div>
    </div>
</x-layout>