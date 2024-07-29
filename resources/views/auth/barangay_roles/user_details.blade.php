@extends('layouts.unified_login_signup')

@section('title', 'User Details')

@section('css')
<link rel="stylesheet" href="{{ asset('resources/css/unified_login_signup/user_details.css') }}">
@endsection

@section('content')
<div class="signup-container">
    <div class="logo">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo">
    </div>
    <div class="separator"></div>
    <h1>{{ session('role') }} User Details</h1>
    <form id="user-details-form" action="{{ route('barangay_roles.userDetails') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required>
            <div class="error-message" id="first_name_error">The first name field must be at least 2 characters.</div>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <div class="error-message" id="gender_error">Gender is required.</div>
        </div>
        <div class="form-group">
            <label for="middle_name">Middle Name</label>
            <input type="text" id="middle_name" name="middle_name">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <div class="error-message" id="email_error">Valid Email is required and must be unique.</div>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required>
            <div class="error-message" id="last_name_error">The last name field must be at least 2 characters.</div>
        </div>
        <div class="form-group">
            <label for="contact_no">Contact Number</label>
            <input type="text" id="contact_no" name="contact_no" required>
            <div class="error-message" id="contact_no_error">Contact Number must be numeric, 10-15 digits, and must be unique.</div>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>
            <div class="error-message" id="dob_error">You must be at least 18 years old.</div>
        </div>
        <div class="form-group">
            <label for="bric_no">BRIC #</label>
            <input type="text" id="bric_no" name="bric_no" required>
            <div class="error-message" id="bric_no_error">BRIC Number must be alphanumeric, 6-20 characters, uppercase, and unique.</div>
        </div>
        <button type="submit" class="btn-primary">Next</button>
    </form>
    <button onclick="window.location='{{ route('barangay_roles.findBarangay') }}'" class="btn-secondary">Back</button>
</div>

<script>
document.getElementById('user-details-form').addEventListener('submit', function(event) {
    let isValid = true;

    const fields = ['first_name', 'gender', 'email', 'last_name', 'contact_no', 'dob', 'bric_no'];
    const alphaRegex = /^[a-zA-Z]+$/;
    const alphanumericRegex = /^[a-zA-Z0-9]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const contactNumberRegex = /^\d{10,15}$/;
    const today = new Date();
    const eighteenYearsAgo = new Date(today.setFullYear(today.getFullYear() - 18));

    fields.forEach(function(field) {
        const input = document.getElementById(field);
        const errorMessage = document.getElementById(field + '_error');

        if (!input.value) {
            isValid = false;
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';

            if (field === 'first_name' || field === 'last_name') {
                if (!alphaRegex.test(input.value) || input.value.length < 2 || input.value.length > 50) {
                    isValid = false;
                    errorMessage.textContent = 'The ' + field.replace('_', ' ') + ' field must be alphabetic, 2-50 characters.';
                    errorMessage.style.display = 'block';
                }
            }

            if (field === 'email' && !emailRegex.test(input.value)) {
                isValid = false;
                errorMessage.textContent = 'The email field must be a valid email address and unique.';
                errorMessage.style.display = 'block';
            }

            if (field === 'contact_no' && !contactNumberRegex.test(input.value)) {
                isValid = false;
                errorMessage.textContent = 'The contact number must be numeric, 10-15 digits, and unique.';
                errorMessage.style.display = 'block';
            }

            if (field === 'dob' && new Date(input.value) > eighteenYearsAgo) {
                isValid = false;
                errorMessage.textContent = 'You must be at least 18 years old.';
                errorMessage.style.display = 'block';
            }

            if (field === 'bric_no' && (!alphanumericRegex.test(input.value) || input.value.length < 6 || input.value.length > 20)) {
                isValid = false;
                errorMessage.textContent = 'The BRIC number must be alphanumeric, 6-20 characters, uppercase, and unique.';
                errorMessage.style.display = 'block';
            }
        }
    });

    if (!isValid) {
        event.preventDefault();
    }
});
</script>
@endsection
