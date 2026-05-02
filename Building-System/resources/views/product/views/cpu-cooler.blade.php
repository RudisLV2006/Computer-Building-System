<x-category title="Check cpu cooler specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Proccesor cooler</span>
    </x-slot>

    <h2>Specifications</h2>
    <table>
        <tr>
            <td>Manufacturer</td>
            <td>{{ $item->manufacturer }}</td>
        </tr>
        <tr>
            <td>TDP</td>
            <td>{{ $item->wattage_w }} W</td>
        </tr>
        <tr>
            <td>Height</td>
            <td>{{ $item->height_mm }} mm</td>
        </tr>
        <tr>
            <td>Supported Sockets</td>
            <td>{{ $item->sockets->pluck('socket')->join(', ') }}</td>
        </tr>
    </table>

</x-category>