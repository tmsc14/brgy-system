@extends('layouts.app')

@section('content')
    <x-login.card-with-logo>
        <div class="col-12 col-lg-8 align-items-center gap-3">
            @if (session('success'))
                <div class="alert alert-success" id="success-message">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('barangay_captain.login.post') }}" method="POST">
                @csrf
                <div class="d-flex flex-column gap-3">
                    <x-form-text-input id="loginEmail" name="email" label="Email" type="email"
                        placeholder="Enter your email here." :errors="$errors" />
                    <div class="form-group">
                        <label class="text-light" for="password">Password</label>
                        <div class="position-relative">
                            <input class="form-control" type="password" name="password" id="password"
                                placeholder="Enter your password here." required />
                            <img id="toggle-password" src="{{ url('resources/img/login-icons/hidepass.png') }}"
                                alt="Show Password"
                                class="icon position-absolute top-50 end-0 translate-middle-y me-2 pe-auto"
                                onclick="togglePassword()">
                        </div>
                        @if ($errors->has('password'))
                            <span class="error">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="text-light" for="barangay">Barangay</label>
                        <select class="form-select" id="barangay" name="barangay" required placeholder="Select your barangay here.">
                            @if (!empty($barangays))
                                @foreach ($barangays as $barangay)
                                    <option value="{{ $barangay->id }}">{{ $barangay->barangay_name }}</option>
                                @endforeach
                            @else
                                <option>No barangays have been registered yet.</option>
                            @endif
                        </select>
                        @error('barangay')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex">
                        <div class="form-check justify-content-around text-light">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input" />
                            <label for="remember" class="form-check-label">
                                Remember Me
                            </label>
                        </div>
                        <a href="#" class="ms-auto">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn btn-primary-brown">Log In</button>
                    <div class="signup-text-container text-center">
                        <span class="signup-text text-light">Don't have an account?</span>&nbsp;
                        <a href="{{ route('barangay_captain.register.step1') }}" class="signup-link">Sign Up Here</a>
                    </div>
                </div>
            </form>
        </div>
    </x-login.card-with-logo>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const togglePassword = document.getElementById('toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePassword.src = '{{ url('resources/img/login-icons/showpass.png') }}';
            } else {
                passwordField.type = 'password';
                togglePassword.src = '{{ url('resources/img/login-icons/hidepass.png') }}';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.transition = 'opacity 1s';
                    successMessage.style.opacity = '0';
                }, 3000); // Time in milliseconds before it fades out
                setTimeout(() => {
                    successMessage.remove();
                }, 4000); // Total time in milliseconds before it is removed
            }
        });
    </script>
@endpush
