@extends('layouts.bc-template-dashboard')

@section('styles')
@vite(['resources/css/barangay_captain/settings/bc-turnover.css'])
@endsection

@section('content')
<div class="turnover-container">
    <h1>Turnover Process</h1>
    <p>Transfer the role of Barangay Captain to another individual.</p>
    
    <form action="{{ route('barangay_captain.turnover') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="new_captain_email">New Barangay Captain Email</label>
            <input type="email" name="email" id="new_captain_email" required>
        </div>

        <!-- Additional form fields for the new Barangay Captain -->
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="btn-primary">Initiate Turnover</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
// Add any specific JavaScript or validation scripts here if needed
</script>
@endsection
