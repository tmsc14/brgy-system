@extends('layouts.create-barangay')

@section('content')
<div class="container">
    <h2>Features Settings</h2>
    <form action="{{ route('barangay_captain.features_settings.post') }}" method="POST">
        @csrf
        <!-- Add your form fields here -->
        <div class="form-group">
            <label for="feature_1">Feature 1</label>
            <input type="text" name="feature_1" id="feature_1" class="form-control" required>
        </div>
        <!-- Add more features settings fields as needed -->
        <button type="submit" class="btn btn-primary">Finish</button>
    </form>
</div>
@endsection
