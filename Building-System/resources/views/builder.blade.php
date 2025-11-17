<x-layout>
    <div class="builder-container">
        <div class="builder-header">
            <h1 class="builder-title">PC Builder</h1>
            <p class="builder-subtitle">Select components for your custom build</p>
        </div>

        <div class="builder-table">
            <table>
                <thead>
                    <tr>
                        <th>Component</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parts as $part)
                        <tr>
                            <td>
                                <a href="{{ route('products.byType', ['type' => $part]) }}" class="part-name-link">
                                    {{ ucfirst($part) }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>