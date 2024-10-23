<div class="{{ $attributes->get('class') }} form-group">
    <x-form-group-label :useDefaultStyle='$useDefaultStyle ?? false' :light='$light ?? false' id="{{ $id }}">{{ $label }}</x-form-group-label>
    <input class="form-control {{ $errors->has($propertyName) ? 'is-invalid' : '' }}" type="{{ $type ?? 'text' }}"
        name="{{ $propertyName }}" id="{{ $id }}" placeholder="{{ $placeholder ?? $label }}"
        {{ $attributes->whereStartsWith('wire') }} />
    @error($propertyName)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
