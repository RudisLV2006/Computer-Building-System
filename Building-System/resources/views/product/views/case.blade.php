<x-category title="Check case specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Case</span>
    </x-slot>

    <h2>Specifications</h2>
    <table>
        <tr>
            <td>Manufacturer</td>
            <td>{{ $item->manufacturer }}</td>
        </tr>
        <tr>
            <td>Case Type</td>
            <td>{{ $item->case_type }}</td>
        </tr>
        <tr>
            <td>Dimensions</td>
            <td>{{ $item->height_mm }} x {{ $item->length_mm }} x {{ $item->width_mm }} mm</td>
        </tr>
    </table>

    <h2>Clearance</h2>
    <table>
        <tr>
            <td>Max GPU Length</td>
            <td>{{ $item->max_gpu_length_mm }} mm</td>
        </tr>
        <tr>
            <td>Max Cooler Height</td>
            <td>{{ $item->max_cooler_height_mm }} mm</td>
        </tr>
        <tr>
            <td>Max PSU Length</td>
            <td>{{ $item->max_psu_length_mm ?? 'No limit' }} mm</td>
        </tr>
    </table>

</x-category>