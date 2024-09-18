@extends('layouts.unified_login_signup')

@section('title', 'Login')

@section('css')
    @vite(['resources/css/unified_login_signup/unified_login.css'])
@endsection

@section('content')
<div class="login-container">
    <div class="login-header">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="logo">
        <div class="line"></div>
    </div>
    <h2>Barangay Login</h2>
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('barangay_roles.unifiedLogin') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="barangay_official">Barangay Official</option>
                <option value="barangay_staff">Staff</option>
                <option value="barangay_resident">Resident</option>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" required>
                <img src="{{ url('resources/img/login-icons/showpass.png') }}" alt="Show Password" class="toggle-password" onclick="togglePassword('password')">
            </div>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="barangay">Barangay</label>
            <select id="barangay" name="barangay" required>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->id }}">{{ $barangay->barangay_name }}</option>
                @endforeach
            </select>
            @error('barangay')
                <span class="error">{{ $message }}</span>
            @enderror
            <!-- Error message for inactive account under the password field -->
            @if ($errors->has('status'))
                <span class="error">{{ $errors->first('status') }}</span>
            @endif
        </div>
        <div class="form-group checkbox-group">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
        <button type="submit" class="btn-primary">Log In</button>
        <p class="sign-up-link">Don't have an account? <a href="{{ route('barangay_roles.showSelectRole') }}">Sign Up Here</a></p>
    </form>
</div>

<script>
    function togglePassword(id) {
        const passwordField = document.getElementById(id);
        const togglePassword = passwordField.nextElementSibling;
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            togglePassword.src = '{{ url("resources/img/login-icons/hidepass.png") }}';
        } else {
            passwordField.type = 'password';
            togglePassword.src = '{{ url("resources/img/login-icons/showpass.png") }}';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
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
@endsection
