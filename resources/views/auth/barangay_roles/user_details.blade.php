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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="user-details-form" action="{{ route('barangay_roles.userDetails') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" required value="{{ old('first_name') }}">
            @if ($errors->has('first_name'))
                <div class="error-message">{{ $errors->first('first_name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @if ($errors->has('gender'))
                <div class="error-message">{{ $errors->first('gender') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="middle_name">Middle Name</label>
            <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
            @if ($errors->has('middle_name'))
                <div class="error-message">{{ $errors->first('middle_name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="{{ old('email') }}">
            @if ($errors->has('email'))
                <div class="error-message">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" required value="{{ old('last_name') }}">
            @if ($errors->has('last_name'))
                <div class="error-message">{{ $errors->first('last_name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="contact_no">Contact Number</label>
            <input type="text" id="contact_no" name="contact_no" required value="{{ old('contact_no') }}">
            @if ($errors->has('contact_no'))
                <div class="error-message">{{ $errors->first('contact_no') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required value="{{ old('dob') }}">
            @if ($errors->has('dob'))
                <div class="error-message">{{ $errors->first('dob') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="bric_no">BRIC #</label>
            <input type="text" id="bric_no" name="bric_no" required value="{{ old('bric_no') }}">
            @if ($errors->has('bric_no'))
                <div class="error-message">{{ $errors->first('bric_no') }}</div>
            @endif
        </div>
        <button type="submit" class="btn-primary">Next</button>
    </form>
    <button onclick="window.location='{{ route('barangay_roles.findBarangay') }}'" class="btn-secondary">Back</button>
</div>
@endsection
