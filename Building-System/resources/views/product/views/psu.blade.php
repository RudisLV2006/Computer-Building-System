<x-category title="Check psu specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Power supply unit</span>
    </x-slot>
    <div class="spec-card">
        <h2>Specifications</h2>
        <table class="spec-table">
            <tr>
                <td>Manufacturer</td>
                <td>{{ $item->manufacturer }}</td>
            </tr>
            <tr>
                <td>Type</td>
                <td>{{ $item->psu_type }}</td>
            </tr>
            <tr>
                <td>Wattage</td>
                <td>{{ $item->wattage_w }} W</td>
            </tr>
            <tr>
                <td>Length</td>
                <td>{{ $item->length }} mm</td>
            </tr>
            <tr>
                <td>Modular</td>
                <td>{{ $item->modular }}</td>
            </tr>
        </table>

        <h2>Connectors</h2>
        <table class="spec-table">
            <tr>
                <td>ATX 4-pin</td>
                <td>{{ $item->atx_4pin_connectors }}</td>
            </tr>
            <tr>
                <td>EPS 8-pin</td>
                <td>{{ $item->eps_8pin_connectors }}</td>
            </tr>
            <tr>
                <td>PCIe 16-pin 12VHPWR</td>
                <td>{{ $item->pcie_16pin_12vhpwr_connectors }}</td>
            </tr>
            <tr>
                <td>PCIe 8-pin</td>
                <td>{{ $item->pcie_8pin_connectors }}</td>
            </tr>
            <tr>
                <td>PCIe 6+2-pin</td>
                <td>{{ $item->pcie_6plus2pin_connectors }}</td>
            </tr>
            <tr>
                <td>PCIe 6-pin</td>
                <td>{{ $item->pcie_6pin_connectors }}</td>
            </tr>
            <tr>
                <td>SATA</td>
                <td>{{ $item->sata_connectors }}</td>
            </tr>
            <tr>
                <td>Molex 4-pin</td>
                <td>{{ $item->molex_4pin_connectors }}</td>
            </tr>
        </table>


</x-category>