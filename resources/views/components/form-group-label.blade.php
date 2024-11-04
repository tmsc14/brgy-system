<label
    class="{{ $useDefaultStyle ?? false
        ? 'text-brown-primary ' . ($light ? 'text-brown-secondary' : 'text-brown-primary')
        : '' }}"
    for="{{ $id }}">{{ $slot }}</label>
