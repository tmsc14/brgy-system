<label
    class="{{ $useDefaultStyle ?? false
        ? 'text-brown-primary ' . ($light ? 'text-brown-secondary' : 'text-brown-primary')
        : 'brgy-color-text' }}"
    for="{{ $id }}">{{ $slot }}</label>
