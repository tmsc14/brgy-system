@extends('layouts.role_dashboard')

@section('content')
<h1>Statistics</h1>

@if ($features->contains('name', 'residents_enabled'))
    <p>Number of Residents: {{ $totalResidentsCount }}</p>
@endif

@if ($features->contains('name', 'households_enabled'))
    <p>Number of Households: {{ $householdsCount }}</p>
@endif

<!-- Add more statistics based on the enabled features -->
@endsection

