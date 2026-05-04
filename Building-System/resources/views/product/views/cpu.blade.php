<x-category title="Check cpu specs" :category="$category" :item="$item">

    <x-slot name="type">
        <span class="product-type">Processor</span>
    </x-slot>
    <div class="spec-card">
        <h2>Specifications</h2>
        <table class="spec-table">
            <tr>
                <td>Socket</td>
                <td>{{ $item->socket }}</td>
            </tr>
            <tr>
                <td>Base Clock</td>
                <td>{{ $item->cpu_speed_ghz }} GHz</td>
            </tr>
            <tr>
                <td>TDP</td>
                <td>{{ $item->wattage_w }}W</td>
            </tr>
            <tr>
                <td>Integrated Graphics</td>
                <td>{{ $item->integrated_graphics ?? 'No' }}</td>
            </tr>
        </table>

</x-category>