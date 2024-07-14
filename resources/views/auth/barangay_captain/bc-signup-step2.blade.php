@extends('layouts.app')

@section('content')
<div class="signup-container">
    <div class="signup-header">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="logo">
        <div class="line"></div>
    </div>
    <h2>Barangay Captain User Details</h2>
    <form action="{{ route('barangay_captain.register.step2.post') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" required>
            </div>
            <div class="form-group">
                <label for="contact_no">Contact Number</label>
                <input type="text" name="contact_no" id="contact_no" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="bric">BRIC #</label>
                <input type="text" name="bric" id="bric" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Next</button>
        <a href="{{ route('barangay_captain.register.step1') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/bc-signup-step2.css') }}">
@endpush
