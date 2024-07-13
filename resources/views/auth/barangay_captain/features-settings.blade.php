@extends('layouts.app')

@section('content')
    <h1>Features Settings</h1>

    <form action="{{ route('barangay_captain.features_settings.post') }}" method="POST">
        @csrf
        <label for="feature_1">Feature 1:</label>
        <input type="checkbox" name="feature_1" id="feature_1" value="1">

        <!-- Add other features settings fields here -->

        <button type="submit">Save</button>
    </form>
@endsection
