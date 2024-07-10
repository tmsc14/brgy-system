@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('barangay_captain.create_barangay') }}" method="post">
    @csrf
    <label for="region">Region:</label>
    <select id="region" name="region" required></select>

    <label for="province">Province:</label>
    <select id="province" name="province" required></select>

    <label for="city_municipality">City/Municipality:</label>
    <select id="city_municipality" name="city_municipality" required></select>

    <label for="barangay">Barangay:</label>
    <select id="barangay" name="barangay" required></select>

    <button type="submit">Create Barangay</button>
</form>
@endsection
