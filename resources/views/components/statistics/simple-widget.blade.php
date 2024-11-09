<button {{ $attributes->whereStartsWith('wire:click') }} type="button" class="btn brgy-widget col-3 justify-content-center align-items-center d-flex flex-column brgy-bg-secondary py-4 brgy-color-primary flex-grow-1 flex-shrink-1">
    <div>
        <x-dynamic-component :component="'gmdi-' . $iconName" class="bigger-icon" />
    </div>
    <div class='text-center'>
        <x-subtitle>
            {{ $stat['title'] }}
        </x-subtitle>
        <span class="fs-1">
            {{ $stat['count'] }}
        </span>
    </div>
</button>