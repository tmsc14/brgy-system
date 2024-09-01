@extends('layouts.create-barangay')

@section('content')
<div class="features-settings-container">
    <h1>Features Settings</h1>
    <p>Configure the features for your barangay.</p>
    
    <form action="{{ route('barangay_captain.features_settings.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="feature_1">Enable Feature 1</label>
            <input type="checkbox" name="feature_1" id="feature_1" value="1">
        </div>

        <!-- Add more feature settings fields as needed -->

        <button type="submit" class="btn-primary">Confirm and Finish</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
// Add any specific JavaScript or validation scripts here if needed
</script>
@endsection