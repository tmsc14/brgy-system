@extends('layouts.app')

@section('title', 'Register Step 2')

@section('content')
    <form action="{{ route('barangay_captain.register.step2.post') }}" method="POST">
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" id="date_of_birth" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="contact_no">Contact No.:</label>
        <input type="text" name="contact_no" required>

        <label for="bric">BRIC#:</label>
        <input type="text" name="bric" required>

        <button type="submit">Next</button>
        <button type="button" onclick="location.href='{{ route('barangay_captain.register.step1') }}'">Back</button>
    </form>
    </form>
@endsection
