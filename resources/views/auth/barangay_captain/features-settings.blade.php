@extends('layouts.create-barangay')

@section('title', 'Features Settings')

@section('css')
    @vite(['resources/css/barangay_captain/create_barangay/features_settings.css'])
@endsection

@section('content')
<div class="features-settings-container">
    <form action="{{ route('barangay_captain.features_settings.post') }}" method="POST">
        @csrf
            <div class="feature-columns">
                <!-- Example for Statistics and Demographics -->
                <div class="feature-block">
                    <p>Statistics and Demographics:</p>
                    <label>
                        <input type="checkbox" name="features[1]" value="1" {{ in_array(1, $selectedFeatures) ? 'checked' : '' }}>
                        No. of Residents
                    </label>
                    <label>
                        <input type="checkbox" name="features[2]" value="1" {{ in_array(2, $selectedFeatures) ? 'checked' : '' }}>
                        No. of Households
                    </label>
                    <!-- Add more feature items as necessary -->
                </div>
            </div>

            <!-- Example for Statistics and Demographics -->
            <div class="feature-block">
                <p>Statistics and Demographics:</p>
                @foreach($features as $feature)
                    @if ($feature->category === 'statistics_demographics')
                        <label>
                            <input type="checkbox" name="features[{{ $feature->id }}]" value="1"
                            {{ in_array($feature->id, $selectedFeatures) ? 'checked' : '' }}>
                            {{ $feature->label }}
                        </label>
                    @endif
                @endforeach
                <div class="custom-input">
                    <input type="text" name="custom_statistic" placeholder="No. of Renters">
                    <button type="button">Add</button>
                </div>
                <span class="select-all">Select All</span>
            </div>

            <!-- Additional Blocks can be added for other features -->
        </div>

        <button type="submit" class="btn-primary">Confirm</button>
    </form>
</div>
@endsection
