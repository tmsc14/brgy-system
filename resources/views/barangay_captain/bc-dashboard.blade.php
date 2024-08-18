@extends('layouts.bc-template-dashboard')

@section('content')
    @vite(['resources/css/barangay_captain/bc-dashboard.css'])

    <div class="dashboard-banner">
        <div class="barangay-banner">
            <div class="bc-barangay-logo">
                @if ($appearanceSettings && $appearanceSettings->logo_path)
                    <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="{{ $barangayDetails->barangay_name }} Logo">
                @else
                    <img src="{{ asset('resources/img/default-logo.png') }}" alt="Default Barangay Logo">
                @endif
            </div>
            <div class="barangay-details">
                @if ($barangayDetails)
                    <h2>Barangay {{ $barangayDetails->barangay_name }}</h2>
                    <p>{{ $citymunDesc }}, {{ $provinceDesc }}</p>
                    <p>{{ $totalMembers }} Members</p>
                @else
                    <p>No barangay information available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
