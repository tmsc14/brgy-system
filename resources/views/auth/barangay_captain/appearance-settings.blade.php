@extends('layouts.app')

@section('content')
    <h1>Appearance Settings</h1>

    <form action="{{ route('barangay_captain.appearance_settings.post') }}" method="POST">
        @csrf
        <label for="theme_color">Theme Color:</label>
        <input type="text" name="theme_color" id="theme_color" required>

        <!-- Add other appearance settings fields here -->

        <button type="submit">Save</button>
    </form>
@endsection
