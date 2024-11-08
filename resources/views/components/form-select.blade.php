<div class="{{ $attributes->get('class') }} form-group">
    <x-form-group-label :useDefaultStyle='$useDefaultStyle ?? false' :light='$light ?? false'
        id="{{ $id }}">{{ $label }}</x-form-group-label>
    <select class="form-select {{ $errors->has($propertyName) ? 'is-invalid' : '' }}" name="{{ $propertyName }}"
        id="{{ $id }}" {{ $attributes->whereStartsWith('wire') }} @disabled($isDisabled ?? false)>
        @if (!isset($hideDefaultOption))
            <option value="" selected>Select {{ strtolower($label) }}</option>
        @endif
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
