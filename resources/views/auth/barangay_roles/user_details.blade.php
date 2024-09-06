@extends('layouts.unified_login_signup')

@section('title', 'User Details')

@section('css')
    @vite(['resources/css/unified_login_signup/user_details.css'])
@endsection


@section('content')
<div class="signup-container">
    <div class="logo">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo">
    </div>
    <div class="separator"></div>
    <h1>
        @if (session('role') == 'barangay_official')
            Barangay Official User Details
        @elseif (session('role') == 'barangay_staff')
            Barangay Staff User Details
        @elseif (session('role') == 'barangay_resident')
            Barangay Resident User Details
        @else
            User Details
        @endif
    </h1>
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
        <!-- For Barangay Resident only -->
        @if (session('role') === 'barangay_resident')
            <div class="form-group">
                <label for="house_number_building_name">House No./Building</label>
                <input type="text" id="house_number_building_name" name="house_number_building_name" required value="{{ old('house_number_building_name') }}">
                @if ($errors->has('house_number_building_name'))
                    <div class="error-message">{{ $errors->first('house_number_building_name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="street_purok_sitio">Street/Purok/Sitio</label>
                <input type="text" id="street_purok_sitio" name="street_purok_sitio" required value="{{ old('street_purok_sitio') }}">
                @if ($errors->has('street_purok_sitio'))
                    <div class="error-message">{{ $errors->first('street_purok_sitio') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="is_renter">Are you a renter?</label>
                <select id="is_renter" name="is_renter" required>
                    <option value="1" {{ old('is_renter') == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_renter') == '0' ? 'selected' : '' }}>No</option>
                </select>
                @if ($errors->has('is_renter'))
                    <div class="error-message">{{ $errors->first('is_renter') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="employment_status">Employment Status</label>
                <select id="employment_status" name="employment_status" required>
                    <option value="employed" {{ old('employment_status') == 'employed' ? 'selected' : '' }}>Employed</option>
                    <option value="unemployed" {{ old('employment_status') == 'unemployed' ? 'selected' : '' }}>Unemployed</option>
                </select>
                @if ($errors->has('employment_status'))
                    <div class="error-message">{{ $errors->first('employment_status') }}</div>
                @endif
            </div>
        @endif
    </form>
        <!-- Centering the Next button and placing it below the form -->
        <div class="text-center mt-4">
            <button type="submit" form="user-details-form" class="btn-primary">Next</button>
        </div>
    
        <!-- Back button centered as well -->
        <div class="text-center mt-2">
            <button onclick="window.location='{{ route('barangay_roles.findBarangay') }}'" class="btn-secondary">Back</button>
        </div>
</div>
@endsection
