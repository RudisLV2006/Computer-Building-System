<x-category title="Check gpu specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Graphics processing unit
        </span>
    </x-slot>
    <div class="spec-card">
        <h2>Specifications</h2>
        <table class="spec-table">
            <tr>
                <td>Manufacturer</td>
                <td>{{ $item->manufacturer }}</td>
            </tr>
            <tr>
                <td>Chipset</td>
                <td>{{ $item->chipset }}</td>
            </tr>
            <tr>
                <td>Memory</td>
                <td>{{ $item->memory }} GB</td>
            </tr>
            <tr>
                <td>Core Clock</td>
                <td>{{ $item->core_clock_mhz }} MHz</td>
            </tr>
            <tr>
                <td>PCIe Version</td>
                <td>{{ $item->pcie_version }}</td>
            </tr>
            <tr>
                <td>PCIe Lanes</td>
                <td>{{ $item->pcie_lanes }}</td>
            </tr>
            <tr>
                <td>Length</td>
                <td>{{ $item->length }} mm</td>
            </tr>
            <tr>
                <td>TDP</td>
                <td>{{ $item->wattage_w }} W</td>
            </tr>
            <tr>
                <td>8-pin Connectors</td>
                <td>{{ $item->pcie_8pin_count }}</td>
            </tr>
            <tr>
                <td>6-pin Connectors</td>
                <td>{{ $item->pcie_6pin_count }}</td>
            </tr>
            <tr>
                <td>12VHPWR</td>
                <td>{{ $item->has_12vhpwr ? 'Yes' : 'No' }}</td>
            </tr>
        </table>

</x-category>