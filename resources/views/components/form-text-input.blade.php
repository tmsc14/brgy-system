<div class="{{ $attributes->get('class') }} form-group">
    <label class="text-brown-primary" for="{{ $id }}">{{ $label }}</label>
    <input class="form-control {{ $errors->has($propertyName) ? 'is-invalid' : '' }}" type="{{ $type ?? "text" }}" name="{{ $propertyName }}" id="{{ $id }}" placeholder="{{ $placeholder ?? $label }}"
    {{ $attributes->whereStartsWith('wire') }} />
    @error($propertyName)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
