@extends('layouts.app')

@section('content')
<div class="signup-container">
    <div class="signup-header">
        <img class="logo" src="{{ asset('resources/img/logo.png') }}" alt="Brgy+">
        <div class="line"></div>
    </div>
    <h2>Barangay Captain User Details</h2>
    <form action="{{ route('barangay_captain.register.step3.post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="password">Create your own Password</label>
            <input type="password" name="password" id="password" required>
            <div class="password-requirements" id="password-requirements">
                <ul>
                    <li id="length" class="invalid">At least 8 characters long</li>
                    <li id="uppercase" class="invalid">At least one uppercase letter</li>
                    <li id="lowercase" class="invalid">At least one lowercase letter</li>
                    <li id="number" class="invalid">At least one number</li>
                    <li id="special" class="invalid">At least one special character (@$!%*?&)</li>
                </ul>
            </div>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Re-type your Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            @error('password_confirmation')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="access_code">Access Code</label>
            <input type="text" name="access_code" id="access_code" required>
            <small>This is the code from the system developers.</small>
            @error('access_code')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn-primary">Confirm</button>
        <a href="{{ route('barangay_captain.register.step2') }}" class="btn-secondary">Back</a>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/bc-signup-step3.css') }}">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const lengthRequirement = document.getElementById('length');
        const uppercaseRequirement = document.getElementById('uppercase');
        const lowercaseRequirement = document.getElementById('lowercase');
        const numberRequirement = document.getElementById('number');
        const specialRequirement = document.getElementById('special');

        passwordInput.addEventListener('input', function () {
            const value = passwordInput.value;

            // Validate length
            if (value.length >= 8) {
                lengthRequirement.classList.remove('invalid');
                lengthRequirement.classList.add('valid');
            } else {
                lengthRequirement.classList.remove('valid');
                lengthRequirement.classList.add('invalid');
            }

            // Validate uppercase letter
            if (/[A-Z]/.test(value)) {
                uppercaseRequirement.classList.remove('invalid');
                uppercaseRequirement.classList.add('valid');
            } else {
                uppercaseRequirement.classList.remove('valid');
                uppercaseRequirement.classList.add('invalid');
            }

            // Validate lowercase letter
            if (/[a-z]/.test(value)) {
                lowercaseRequirement.classList.remove('invalid');
                lowercaseRequirement.classList.add('valid');
            } else {
                lowercaseRequirement.classList.remove('valid');
                lowercaseRequirement.classList.add('invalid');
            }

            // Validate number
            if (/\d/.test(value)) {
                numberRequirement.classList.remove('invalid');
                numberRequirement.classList.add('valid');
            } else {
                numberRequirement.classList.remove('valid');
                numberRequirement.classList.add('invalid');
            }

            // Validate special character
            if (/[@$!%*?&#]/.test(value)) {
                specialRequirement.classList.remove('invalid');
                specialRequirement.classList.add('valid');
            } else {
                specialRequirement.classList.remove('valid');
                specialRequirement.classList.add('invalid');
            }
        });
    });
</script>
@endpush
