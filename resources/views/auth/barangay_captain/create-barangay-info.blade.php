@extends('layouts.create-barangay')

@section('title', 'Barangay Info')

@section('content')
<form action="{{ route('barangay_captain.create_barangay_info') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="barangay_name">Barangay Name/Title:</label>
        <input type="text" name="barangay_name" id="barangay_name" value="{{ old('barangay_name', $geographicData['barangayDesc']) }}" required readonly>
    </div>
    <div class="form-group">
        <label for="barangay_email">Barangay Email Address:</label>
        <input type="email" name="barangay_email" id="barangay_email" required>
    </div>
    <div class="form-group">
        <p>Barangay Complete Address</p>
        <label for="barangay_complete_address_1">Line 2</label>
        <input type="text" name="barangay_complete_address_1" id="barangay_complete_address_1" required>
        <label for="barangay_complete_address_2">Line 2</label>
        <input type="text" name="barangay_complete_address_2" id="barangay_complete_address_2">
    </div>
    <div class="form-group">
        <label for="barangay_office_address">Barangay Office Address:</label>
        <input type="text" name="barangay_office_address" id="barangay_office_address" required>
    </div>
    <div class="form-group">
        <label for="barangay_description">Barangay Description:</label>
        <textarea name="barangay_description" id="barangay_description" required></textarea>
    </div>
    <div class="form-group">
        <label for="barangay_contact_number">Barangay Contact Number:</label>
        <input type="text" name="barangay_contact_number" id="barangay_contact_number" required>
    </div>
    <!-- Hidden fields to include geographic data -->
    <input type="hidden" name="region" value="{{ $geographicData['region'] }}">
    <input type="hidden" name="province" value="{{ $geographicData['province'] }}">
    <input type="hidden" name="city" value="{{ $geographicData['city'] }}">
    <input type="hidden" name="barangay" value="{{ $geographicData['barangay'] }}">
    
    <button type="submit" class="btn-primary">Next</button>
</form>
@endsection
