@extends('layouts.bc-template-dashboard')

@section('content')

@section('content')
<div class="dashboard-container">
    <h1>Welcome, {{ $user->first_name }}!</h1>
    <p>Your current theme settings:</p>
    <ul>
        <li>Theme Color: {{ $appearanceSettings->theme_color }}</li>
        <li>Primary Color: {{ $appearanceSettings->primary_color }}</li>
        <li>Secondary Color: {{ $appearanceSettings->secondary_color }}</li>
        <li>Text Color: {{ $appearanceSettings->text_color }}</li>
    </ul>
</div>

<div class="barangay-info">
    <div class="barangay-logo">
        <img src="{{ asset('images/barangay-logo.png') }}" alt="Barangay Logo">
    </div>
    <div class="barangay-details">
        @if ($user->barangayDetails)
            <h2>{{ $user->barangayDetails->barangay_name }}</h2>
            <p>{{ $user->barangayDetails->barangay_email }}</p>
            <p>300 Members</p>
        @else
            <p>No barangay information available.</p>
        @endif
    </div>
</div>

<div class="requests-section">
    <h3>Requests</h3>
    <div class="request">
        <div class="request-info">
            <p>Name: Anilov Briant</p>
            <p>Role: Barangay Kagawad</p>
        </div>
        <div class="request-actions">
            <button class="btn-accept">Accept</button>
        </div>
    </div>
</div>

<div class="profile-section">
    <h3>Profile</h3>
    <div class="profile-info">
        <p>Name: Klein Mercado</p>
        <p>Role: Punong Barangay</p>
    </div>
    <div class="admin-count">
        <p>Number of Admins: 6</p>
    </div>
</div>

<div class="calendar-section">
    <h3>Calendar</h3>
    <div class="calendar">
        <p>May 2023</p>
        <!-- Calendar content -->
    </div>
</div>

<div class="statistics-section">
    <h3>Statistics</h3>
    <div class="stats-chart">
        <!-- Chart content -->
    </div>
</div>

<div class="summary-section">
    <div class="summary">
        <p>Number of Households: 100</p>
    </div>
    <div class="summary">
        <p>Number of Residents: 300</p>
    </div>
</div>
@endsection
