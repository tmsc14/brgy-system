<div class="{{ $attributes->get('class') }} form-group">
    <x-form-group-label :useDefaultStyle='$useDefaultStyle ?? false' :light='$light ?? false' id="{{ $id }}">{{ $label }}</x-form-group-label>
    <div class="position-relative">
        <input class="form-control {{ $errors->has($propertyName) ? 'is-invalid' : '' }}" type="password" name="password" id="{{ $id }}"
            placeholder="Enter your password here."
            {{ $attributes->whereStartsWith('wire') }} />
        <img id="toggle-{{ $id }}" src="{{ url('resources/img/login-icons/hidepass.png') }}"
            alt="Show Password"
            class="icon position-absolute top-50 end-0 translate-middle-y me-2 pe-auto"
            onclick="togglePassword('{{ $id }}')">
    </div>
    @error($propertyName)
        <span class="text-danger">{{ $message }}</span>
    @enderror

    @push('scripts')
    <script>
        function togglePassword(id) {
            const passwordField = document.getElementById(id);
            const togglePassword = document.getElementById('toggle-' + id);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePassword.src = '{{ url('resources/img/login-icons/showpass.png') }}';
            } else {
                passwordField.type = 'password';
                togglePassword.src = '{{ url('resources/img/login-icons/hidepass.png') }}';
            }
        }
    </script>
    @endpush
</div>