<button class="btn btn-primary-brgy d-flex align-items-center w-100 p-3 mb-3" {{ $attributes->whereStartsWith('wire') }} >
    <div class="left-content d-flex align-items-center me-auto">
        <x-dynamic-component :component="'gmdi-' . $iconName" class="bigger-icon me-1" />
        <x-title>{{ $text }}</x-title>
    </div>
    <x-gmdi-chevron-right class="ms-auto bigger-icon" />
</button>
