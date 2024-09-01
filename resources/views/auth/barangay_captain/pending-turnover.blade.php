@extends('layouts.bc-template-dashboard')

@section('styles')
@vite(['resources/css/barangay_captain/pending-turnover.css'])
@endsection

@section('content')
<div class="pending-turnover-container">
    <h1>Barangay Already Exists</h1>
    <p>Your barangay location already has an existing Barangay Captain. You cannot create a new barangay until the current Barangay Captain transfers access to you.</p>

    <p>Please wait for the current Barangay Captain to initiate the turnover process.</p>
</div>
@endsection
