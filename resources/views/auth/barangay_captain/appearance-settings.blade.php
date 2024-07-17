@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Appearance Settings</h2>
    <form action="{{ route('barangay_captain.appearance_settings.post') }}" method="POST">
        @csrf
        <!-- Add your form fields here -->
        <div class="form-group">
            <label for="theme_color">Theme Color</label>
            <input type="text" name="theme_color" id="theme_color" class="form-control" required>
        </div>
        <!-- Add more appearance settings fields as needed -->
        <button type="submit" class="btn btn-primary">Next</button>
    </form>
</div>
@endsection
