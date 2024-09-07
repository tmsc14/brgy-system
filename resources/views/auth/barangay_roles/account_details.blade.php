@extends('layouts.unified_login_signup')

@section('title', 'Account Details')

@section('css')
    @vite(['resources/css/unified_login_signup/account_details.css'])
@endsection

@section('content')
<div class="signup-container">
    <div class="logo">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="img-fluid">
    </div>
    <div class="separator"></div>
    <h1>
        @if (session('role') == 'barangay_official')
            Barangay Official Account Details
        @elseif (session('role') == 'barangay_staff')
            Barangay Staff Account Details
        @elseif (session('role') == 'barangay_resident')
            Barangay Resident Account Details
        @else
            Account Details
        @endif
    </h1>
    <form action="{{ route('barangay_roles.accountDetails') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
        @csrf
        <div class="form-group">
            <label for="password">Create Your Own Password:</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" class="form-control" required>
                <img src="{{ asset('resources/img/login-icons/hidepass.png') }}" id="toggle-password" class="toggle-password" alt="Toggle Password">
                <div id="password-requirements" class="password-requirements">
                    <ul>
                        <li id="length" class="invalid">At least 8 characters long</li>
                        <li id="uppercase" class="invalid">At least one uppercase letter</li>
                        <li id="lowercase" class="invalid">At least one lowercase letter</li>
                        <li id="number" class="invalid">At least one number</li>
                        <li id="special" class="invalid">At least one special character (@$!%*?&)</li>
                    </ul>
                </div>
            </div>
            @if ($errors->has('password'))
                <div class="error">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="password_confirmation">Re-type Your Password:</label>
            <div class="password-wrapper">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                <img src="{{ asset('resources/img/login-icons/hidepass.png') }}" id="toggle-password-confirmation" class="toggle-password" alt="Toggle Password">
            </div>
            @if ($errors->has('password_confirmation'))
                <div class="error">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="valid_id">Valid ID:</label>
            <input type="file" id="valid_id" name="valid_id" class="form-control-file" required>
            <div class="note">File types: jpg, png, pdf. Max size: 5MB.</div>
            @if ($errors->has('valid_id'))
                <div class="error">{{ $errors->first('valid_id') }}</div>
            @endif
        </div>
        @if(session('role') == 'barangay_official')
            <div class="form-group">
                <label for="position">Position:</label>
                <select id="position" name="position" class="form-control" required>
                    <option value="Sangguniang Barangay Member">Sangguniang Barangay Member</option>
                    <option value="SK Chairperson">SK Chairperson</option>
                    <option value="Barangay Secretary">Barangay Secretary</option>
                </select>
                @if ($errors->has('position'))
                    <div class="error">{{ $errors->first('position') }}</div>
                @endif
            </div>
        @elseif(session('role') == 'barangay_staff')
            <div class="form-group">
                <label for="position">Role:</label>
                <select id="position" name="position" class="form-control" required>
                    <option value="Cashier">Cashier</option>
                    <option value="Clerk">Clerk</option>
                    <option value="Manager">Manager</option>
                </select>
                @if ($errors->has('position'))
                    <div class="error">{{ $errors->first('position') }}</div>
                @endif
            </div>
        @endif
        <button type="submit" class="btn-primary">Confirm</button>
        <button type="button" class="btn-secondary" onclick="window.location='{{ route('barangay_roles.showUserDetails') }}'">Back</button>
    </form>
</div>

<script>
// Toggle password visibility and password strength requirements
document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.getElementById('toggle-password');
    const password = document.getElementById('password');
    const togglePasswordConfirmation = document.getElementById('toggle-password-confirmation');
    const passwordConfirmation = document.getElementById('password_confirmation');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.src = type === 'password' ? '{{ asset("resources/img/login-icons/hidepass.png") }}' : '{{ asset("resources/img/login-icons/showpass.png") }}';
    });

    togglePasswordConfirmation.addEventListener('click', function () {
        const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmation.setAttribute('type', type);
        this.src = type === 'password' ? '{{ asset("resources/img/login-icons/hidepass.png") }}' : '{{ asset("resources/img/login-icons/showpass.png") }}';
    });

    password.addEventListener('input', function() {
        const value = password.value;
        document.getElementById('length').classList.toggle('valid', value.length >= 8);
        document.getElementById('length').classList.toggle('invalid', value.length < 8);

        document.getElementById('uppercase').classList.toggle('valid', /[A-Z]/.test(value));
        document.getElementById('uppercase').classList.toggle('invalid', !/[A-Z]/.test(value));

        document.getElementById('lowercase').classList.toggle('valid', /[a-z]/.test(value));
        document.getElementById('lowercase').classList.toggle('invalid', !/[a-z]/.test(value));

        document.getElementById('number').classList.toggle('valid', /[0-9]/.test(value));
        document.getElementById('number').classList.toggle('invalid', !/[0-9]/.test(value));

        document.getElementById('special').classList.toggle('valid', /[@$!%*?&]/.test(value));
        document.getElementById('special').classList.toggle('invalid', !/[@$!%*?&]/.test(value));
    });

    const passwordWrapper = document.querySelector('.password-wrapper');
    passwordWrapper.addEventListener('mouseenter', function() {
        document.getElementById('password-requirements').style.display = 'block';
    });

    passwordWrapper.addEventListener('mouseleave', function() {
        document.getElementById('password-requirements').style.display = 'none';
    });
});
</script>
@endsection
