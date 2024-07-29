@extends('layouts.unified_login_signup')

@section('title', 'Sign Up As')

@section('css')
<link rel="stylesheet" href="{{ asset('resources/css/unified_login_signup/select_role.css') }}">
@endsection

@section('content')
<div class="signup-container">
    <div class="logo">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo">
    </div>
    <div class="separator"></div>
    <h1>Sign Up As</h1>
    <form action="{{ route('barangay_roles.selectRole') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="role">Select Role:</label>
            <select id="role" name="role" required>
                <option value="barangay_official">Barangay Official</option>
                <option value="barangay_staff">Staff</option>
                <option value="barangay_resident">Resident</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Next</button>
    </form>
    <button onclick="window.location='{{ route('home') }}'" class="btn-secondary">Back</button>
</div>
@endsection
