@extends('layouts.role_dashboard')

@section('content')
<div class="statistics-container">
    <div class="statistics-header">
        <h1>Statistics</h1>
    </div>

    @if ($features->contains('name', 'residents_enabled'))
        <div class="stat-item">
            {{-- Residents Icon --}}
            <img src="{{ Vite::asset('resources/img/statistics-icon/house-icon.png') }}" alt="Residents Icon" class="stat-icon">
            <h3>Number of Residents</h3>
            <div class="value">{{ $totalResidentsCount }}</div>
        </div>
    @endif

    @if ($features->contains('name', 'households_enabled'))
        <div class="stat-item">
            {{-- Households Icon --}}
            <img src="{{ Vite::asset('resources/img/statistics-icon/house-icon.png') }}" alt="Households Icon" class="stat-icon">
            <h3>Number of Households</h3>
            <div class="value">{{ $householdsCount }}</div>
        </div>
    @endif

    @if ($features->contains('name', 'gender_enabled'))
        <div class="stat-item">
            {{-- Gender Icon and Header --}}
            <div class="gender-header">
                <img src="{{ Vite::asset('resources/img/statistics-icon/gender-icon.png') }}" alt="Gender Icon" class="stat-icon">
                <h3>Gender Demographics</h3>
            </div>
            <div class="pie-chart-container">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    @endif

    @if ($features->contains('name', 'age_demographics_enabled'))
        <div class="stat-item">
            {{-- Children Icon --}}
            <img src="{{ Vite::asset('resources/img/statistics-icon/child-icon.png') }}" alt="Children Icon" class="stat-icon">
            <h3>Children</h3>
            <div class="value">{{ $ageDemographics['children'] ?? 0 }}</div>
        </div>

        <div class="stat-item">
            {{-- Adults Icon --}}
            <img src="{{ Vite::asset('resources/img/statistics-icon/adult-icon.png') }}" alt="Adults Icon" class="stat-icon">
            <h3>Adults</h3>
            <div class="value">{{ $ageDemographics['adults'] ?? 0 }}</div>
        </div>

        <div class="stat-item">
            {{-- Senior Citizens Icon --}}
            <img src="{{ Vite::asset('resources/img/statistics-icon/old-icon.png') }}" alt="Senior Citizens Icon" class="stat-icon">
            <h3>Senior Citizens</h3>
            <div class="value">{{ $ageDemographics['senior_citizens'] ?? 0 }}</div>
        </div>
    @endif
</div>
@endsection

@section('styles')
    @vite(['resources/css/barangay_staff/statistics/bs-statistics.css']) <!-- Modify for bo-statistics -->
@endsection

@section('scripts')
    <script>
        var genderDemographicsMale = {{ $genderDemographics['Male'] ?? 0 }};
        var genderDemographicsFemale = {{ $genderDemographics['Female'] ?? 0 }};
        var genderDemographicsOther = {{ $genderDemographics['Other'] ?? 0 }};
    </script>

    @vite(['resources/js/statistics.js'])
@endsection