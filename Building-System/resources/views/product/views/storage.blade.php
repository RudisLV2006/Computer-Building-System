<x-category title="Check storage specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Storage</span>
    </x-slot>

    <h2>Specifications</h2>
    <table>
        <tr>
            <td>Capacity</td>
            <td>{{ $item->capacity_gb }} GB</td>
        </tr>
        <tr>
            <td>Type</td>
            <td>{{ $item->type }}</td>
        </tr>
        <tr>
            <td>Form Factor</td>
            <td>{{ $item->form_factor }}</td>
        </tr>
        <tr>
            <td>Interface</td>
            <td>{{ $item->interface }}</td>
        </tr>
    </table>

</x-category>