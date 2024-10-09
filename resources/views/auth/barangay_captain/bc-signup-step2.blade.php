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
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', session('first_name')) }}" required>
                @error('first_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" required>
                    <option value="" disabled {{ !old('gender', session('gender')) ? 'selected' : '' }}>Select Gender</option>
                    <option value="Male" {{ old('gender', session('gender')) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', session('gender')) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', session('gender')) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', session('middle_name')) }}">
                @error('middle_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', session('email')) }}" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', session('last_name')) }}" required>
                @error('last_name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', session('contact_number')) }}" required>
                @error('contact_number')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', session('date_of_birth')) }}" required>
                @error('date_of_birth')
                    <span class="error">{{ $message }}</span>
                @enderror
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameFields = ['first_name', 'middle_name', 'last_name'];
        nameFields.forEach(field => {
            const input = document.getElementById(field);
            input.addEventListener('input', function () {
                this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();
            });
        });

        const bricInput = document.getElementById('bric');
        bricInput.addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endpush
