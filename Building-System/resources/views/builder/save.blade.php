<x-layout title="Save Your Build">
    <div class="builder-container">
        <div class="builder-header">
            <h1 class="builder-title">Save Build</h1>
        </div>

        <div class="save-card">
            <form action="{{ route('builder.save') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label for="name" style="font-weight: 700; color: var(--text-main);">Give your build a name</label>
                    <input type="text" name="name" id="name" required placeholder="e.g. Ultimate Gaming 2026">
                </div>

                @foreach($products as $category => $items)
                @foreach($items as $item)
                <input type="hidden" name="products[{{ $category }}][{{ $loop->index }}][id]" value="{{ $item['product']->id }}">
                <input type="hidden" name="products[{{ $category }}][{{ $loop->index }}][count]" value="{{ $item['count'] }}">
                @endforeach
                @endforeach

                <button type="submit" class="btn-success" style="width: 100%; padding: 1rem;">
                    Confirm & Save to Community Builds
                </button>
            </form>
        </div>

        {{-- Review Table --}}
        <h2 style="margin-bottom: 1rem;">Review Components</h2>
        <div class="builder-table" style="opacity: 0.7;">
            <table>
                @foreach($categories as $category)
                @if($products->has($category))
                <tr>
                    <td>{{ ucfirst($category) }}</td>
                    <td>
                        @foreach($products[$category] as $item)
                        {{ $item['product']->name }} (x{{ $item['count'] }}){{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
    </div>
</x-layout>