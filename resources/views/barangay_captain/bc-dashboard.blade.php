@extends('layouts.bc-dashboard')

@section('content')
<div class="barangay-info">
    <div class="barangay-logo">
        <img src="{{ asset('images/barangay-logo.png') }}" alt="Barangay Logo">
    </div>
    <div class="barangay-details">
        @if (is_object(Auth::user()->barangay))
            <h2>{{ Auth::user()->barangay->name }}</h2>
            <p>{{ Auth::user()->barangay->location }}</p>
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
