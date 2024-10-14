<div class="{{ $attributes->get('class') }} form-group">
    <label class="text-brown-primary fw -bold" for="{{ $id }}">{{ $label }}</label>
    <select class="form-select {{ $errors->has($propertyName) ? 'is-invalid' : '' }}" name="{{ $propertyName }}" id="{{ $id }}" @disabled($isDisabled ?? false)
        {{ $attributes->whereStartsWith('wire') }}>
        <option value="" selected>Select {{ strtolower($label) }}</option>
        @if (!empty($options))
            @foreach ($options as $option)
                <option value="{{ $option[$optionValueKey] }}">{{ $option[$optionLabelKey] }}</option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>
    @error($propertyName)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
