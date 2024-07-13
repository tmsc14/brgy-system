@extends('layouts.app')

@section('content')
    <h1>Create Barangay</h1>

    <form action="{{ route('barangay_captain.create_barangay_info') }}" method="POST">
        @csrf
        <div>
            <label for="barangay_name">Barangay Name:</label>
            <input type="text" name="barangay_name" id="barangay_name" value="{{ old('barangay_name', $barangayDesc) }}" required readonly>
        </div>

        <label for="barangay_email">Email:</label>
        <input type="email" name="barangay_email" id="barangay_email" required>

        <label for="barangay_office_address">Office Address:</label>
        <input type="text" name="barangay_office_address" id="barangay_office_address" required>

        <label for="barangay_complete_address_1">Complete Address 1:</label>
        <input type="text" name="barangay_complete_address_1" id="barangay_complete_address_1" required>

        <label for="barangay_complete_address_2">Complete Address 2:</label>
        <input type="text" name="barangay_complete_address_2" id="barangay_complete_address_2">

        <label for="barangay_description">Description:</label>
        <textarea name="barangay_description" id="barangay_description" required></textarea>

        <label for="barangay_contact_number">Contact Number:</label>
        <input type="text" name="barangay_contact_number" id="barangay_contact_number" required>

        <button type="submit">Submit</button>
    </form>
@endsection
