<div>
    <x-icon-header text="Documents / Request" iconName="description" />
    <x-container>
        <div class="mb-1 d-flex align-items-center">
            <x-gmdi-description class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Request</x-title>
        </div>
        <div class="document-types-container brgy-bg-content">
            @foreach ($documentRequestTypes as $type)
                <div class="document-type-entry brgy-color-secondary d-flex brgy-bg-primary">
                    <div class="type-name">
                        {{ $type->getDescription() }}
                    </div>
                    <button class="btn btn-secondary-brgy request-btn"
                        wire:click="requestDocument('{{ $type->name }}')">Request</button>
                </div>
            @endforeach
        </div>
        <a href="/documents" wire.navigate>
            <button class="btn btn-secondary-brgy">Back</button>
        </a>
    </x-container>
</div>
