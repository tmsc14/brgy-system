<div class="form-group">
    <label class="text-brown-secondary" for="{{ $id ?? $name }}">{{ $label }}</label>
    <select class="form-select" name="{{ $name }}" id="{{ $id ?? $name }}" @disabled($isDisabled ?? false)
        {{ $attributes->whereStartsWith('wire:model') }}>
        <option value="" selected>Select {{ strtolower($label) }}</option>
        @foreach ($options as $option)
            <option value="{{ $option[$optionValueKey] }}">{{ $option[$optionLabelKey] }}</option>
        @endforeach
    </select>
    @error($propertyName)
        <span class="error">{{ $message }}</span>
    @enderror
</div>
