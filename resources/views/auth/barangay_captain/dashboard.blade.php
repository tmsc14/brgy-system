@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <img src="{{ url('resources/img/logo.png') }}" alt="Logo" class="logo">
        <div class="welcome-message">
            Welcome, {{ $user->first_name }} {{ $user->last_name }}
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="dashboard-main">
        @if (!$barangayDetails)
            <p>You have not created a barangay yet.</p>
            <a href="{{ route('barangay_captain.create_barangay_info_form') }}" class="btn btn-primary">Create Barangay</a>
        @else
            <p>You have already created a barangay: {{ $barangayDetails->barangay_name }}</p>
            <a href="{{ route('barangay_captain.appearance_settings') }}" class="btn btn-secondary">Appearance Settings</a>
            <a href="{{ route('barangay_captain.features_settings') }}" class="btn btn-secondary">Features Settings</a>
            <a href="{{ route('bc-dashboard') }}" class="btn btn-secondary">Go to Dashboard</a>
        @endif
    </div>

    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('resources/css/dashboard.css') }}">
@endpush
