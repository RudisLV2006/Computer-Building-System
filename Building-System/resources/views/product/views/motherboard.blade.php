<x-category title="Check motherboard specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Motherboard</span>
    </x-slot>

    <h2>Specifications</h2>
    <table>
        <tr>
            <th>Socket</th>
            <td>{{ $item->socket }}</td>
        </tr>
        <tr>
            <th>Chipset</th>
            <td>{{ $item->chipset }}</td>
        </tr>
        <tr>
            <th>Form Factor</th>
            <td>{{ $item->form_factor }}</td>
        </tr>
        <tr>
            <th>Memory Type</th>
            <td>{{ $item->memory_technology }}</td>
        </tr>
        <tr>
            <th>Memory Slots</th>
            <td>{{ $item->memory_slots }}</td>
        </tr>
        <tr>
            <th>Pci Express</th>
            <td>{{ $item->pcie_version }}</td>
        </tr>
    </table>
</x-category>