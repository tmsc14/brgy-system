@extends('layouts.role_dashboard')

@section('styles')
    @vite(['resources/css/barangay_resident/household-management/br-household-index.css'])
@endsection

@section('content')
<div class="household-index-container">
    <h2>Your Household Members</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @foreach($households as $household)
        <div class="household-member">
            <p><strong>Name:</strong> {{ $household->first_name }} {{ $household->middle_name }} {{ $household->last_name }}</p>
            <p><strong>Date of Birth:</strong> {{ $household->dob }}</p>
            <p><strong>BRIC #:</strong> {{ $household->bric_no }}</p>
            <p><strong>Gender:</strong> {{ $household->gender }}</p>
        </div>
    @endforeach

    <a href="{{ route('households.create') }}" class="btn btn-primary">Add New Member</a>
</div>
@endsection
