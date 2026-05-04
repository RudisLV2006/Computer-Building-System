<x-layout>
    <div class="container">
        <div class="builder-header">
            <h1 class="builder-title">All Computer Builds</h1>
            <p class="builder-subtitle">Explore community configurations or use them as a starting point.</p>
        </div>

        @if($builds->isEmpty())
        <div class="choice">
            <p class="text-muted">No builds found. Go create one!</p>
            <a href="{{ route('builder.index') }}">Start Building</a>
        </div>
        @else
        <div class="builds-grid">
            @foreach($builds as $build)
            <div class="build-card">
                <div class="build-card-header">
                    <strong>Build #{{ $build->id }}</strong>
                    <strong>{{ $build->name }}</strong>
                    <span>{{ $build->created_at->format('M d, Y') }}</span>
                </div>

                <div class="build-card-body">
                    <h5 class="section-label">Components List</h5>
                    <ul class="build-component-list">
                        @foreach($build->items as $item)
                        <li>
                            <div class="component-info">
                                <span class="product-type-pill">{{ $item->category }}</span>
                                <span class="product-id">ID: {{ $item->product_id }}</span>
                            </div>
                            <span class="component-count">x{{ $item->count }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="build-card-footer">
                    <div class="footer-meta">
                        <small>By: {{ $build->user->name ?? 'Guest' }}</small>
                        <small>Updated {{ $build->updated_at->diffForHumans() }}</small>
                    </div>

                    <form action="{{route('builder.use', $build->id)}}" method="post">
                        @csrf
                        <button type="submit" class="use-build-btn">
                            Use Build
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</x-layout>