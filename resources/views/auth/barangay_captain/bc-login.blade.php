@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-header">
        <img src="{{ url('resources/img/logo.png') }}" alt="Logo" class="logo">
    </div>
    <h2>Barangay Captain Login</h2>
    @if (session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('barangay_captain.login.post') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your Email here" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Please Enter Your Password" required>
        </div>
        <div class="form-check">
            <label for="remember" class="form-check-label">
                <input type="checkbox" name="remember" id="remember" class="form-check-input"> Remember Me
            </label>
            <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
        <button type="submit" class="btn btn-primary">Log In</button>
        <div class="signup-text-container">
            <span class="signup-text">Don’t have an account?</span>
            <a href="{{ route('barangay_captain.register.step1') }}" class="signup-link">Sign Up Here</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('resources/css/bc-login.css') }}">
@endpush

@push('scripts')
    <script>
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
@endpush
