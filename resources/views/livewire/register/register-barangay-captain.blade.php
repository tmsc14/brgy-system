<x-login.card-with-logo>
    <hr class="line text-brown-secondary w-100"/>
    <div class="wizard-container w-100">
        <livewire:register-wizard />
    </div>

    {{-- Have to put this script here as the script inside the password component doesn't get pushed to the scripts stack due to the password field being in the second step. It's not part of the initial render. --}}
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
</x-login.card-with-logo>
