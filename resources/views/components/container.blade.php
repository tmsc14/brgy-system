<div {{ $attributes->merge(['class' => 'brgy-bg-primary rounded p-3']) }}>
    @if (isset($iconName) || isset($title))
        <div class="d-flex align-items-center mb-2">
            @if (isset($iconName))
                <x-dynamic-component :component="'gmdi-' . $iconName" class="bigger-icon brgy-primary-text me-1" />
            @endif
            @if (isset($title))
                <x-title class="brgy-primary-text">{{ $title }}</x-title>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
