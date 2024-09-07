@extends('layouts.role_dashboard')

@section('styles')
    @vite(['resources/css/barangay_official/statistics/bo-statistics.css'])
@endsection

@section('content')
<h1 class="statistics-header">Statistics</h1>

<div class="container-fluid">
    <div class="row">
        @if ($features->contains('name', 'residents_enabled'))
            <div class="col-md-6">
                <div class="statistics-card">
                    <p class="card-title">Number of Residents</p>
                    <p class="card-content">{{ $totalResidentsCount }}</p>
                </div>
            </div>
        @endif

        @if ($features->contains('name', 'households_enabled'))
            <div class="col-md-6">
                <div class="statistics-card">
                    <p class="card-title">Number of Households</p>
                    <p class="card-content">{{ $householdsCount }}</p>
                </div>
            </div>
        @endif

        <!-- Add more statistics based on the enabled features -->
    </div>
</div>
@endsection
