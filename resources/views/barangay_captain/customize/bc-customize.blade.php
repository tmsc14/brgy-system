@extends('layouts.bc-template-dashboard')

@section('styles')
    @vite(['resources/css/barangay_captain/customize/bc-customize.css'])
@endsection

@section('content')
<div class="bc-customize-container">
    <h1>Customize Barangay Settings</h1>

    <!-- Barangay Info Section -->
    <div class="customize-section">
        <h2>Barangay Information</h2>
        <form action="{{ route('barangay_captain.create_barangay_info') }}" method="POST" id="barangay-info-form">
            @csrf
            <div class="form-group">
                <label for="barangay_name">Barangay Name/Title:</label>
                <input type="text" name="barangay_name" id="barangay_name" 
                    value="{{ old('barangay_name', $barangay->barangay_name ?? $geographicData['barangayDesc']) }}" required readonly>
            </div>
            <div class="form-group">
                <label for="barangay_email">Barangay Email Address:</label>
                <input type="email" name="barangay_email" id="barangay_email" 
                    value="{{ old('barangay_email', $barangay->barangay_email ?? '') }}" required>
            </div>
            <div class="form-group">
                <p>Barangay Complete Address</p>
                <label for="barangay_complete_address_1">Line 1</label>
                <input type="text" name="barangay_complete_address_1" id="barangay_complete_address_1" 
                    value="{{ old('barangay_complete_address_1', $barangay->barangay_complete_address_1 ?? '') }}" required>
                <label for="barangay_complete_address_2">Line 2</label>
                <input type="text" name="barangay_complete_address_2" id="barangay_complete_address_2" 
                    value="{{ old('barangay_complete_address_2', $barangay->barangay_complete_address_2 ?? '') }}">
            </div>
            <div class="form-group">
                <label for="barangay_office_address">Barangay Office Address:</label>
                <input type="text" name="barangay_office_address" id="barangay_office_address" 
                    value="{{ old('barangay_office_address', $barangay->barangay_office_address ?? '') }}" required>
            </div>
            <div class="form-group">
                <label for="barangay_description">Barangay Description:</label>
                <textarea name="barangay_description" id="barangay_description" required>{{ old('barangay_description', $barangay->barangay_description ?? '') }}</textarea>
            </div>
            <div class="form-group">
                <label for="barangay_contact_number">Barangay Contact Number:</label>
                <input type="text" name="barangay_contact_number" id="barangay_contact_number" 
                    value="{{ old('barangay_contact_number', $barangay->barangay_contact_number ?? '') }}" required>
            </div>
            <button type="submit" class="btn-primary">Save Barangay Info</button>
        </form>
    </div>

    <!-- Appearance Settings Section -->
    <div class="customize-section">
        <h2>Appearance Settings</h2>
        <div class="appearance-container">
            <form action="{{ route('barangay_captain.appearance_settings.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="from_customization" value="true">
                <div class="appearance-form-group">
                    <label for="theme">Select Theme</label>
                    <select name="theme" id="theme" class="appearance-form-control">
                        <option value="">Custom</option>
                        <option value="default">Default</option>
                        <option value="dark">Dark</option>
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                    </select>
                </div>
                <div class="appearance-form-group">
                    <label for="theme_color">Theme Color</label>
                    <input type="color" name="theme_color" id="theme_color" class="appearance-form-control" value="{{ $appearanceSettings->theme_color }}" required>
                    <span class="color-box" id="theme_color_box" style="background-color: {{ $appearanceSettings->theme_color }}"></span>
                </div>
                <div class="appearance-form-group">
                    <label for="primary_color">Primary Color</label>
                    <input type="color" name="primary_color" id="primary_color" class="appearance-form-control" value="{{ $appearanceSettings->primary_color }}" required>
                    <span class="color-box" id="primary_color_box" style="background-color: {{ $appearanceSettings->primary_color }}"></span>
                </div>
                <div class="appearance-form-group">
                    <label for="secondary_color">Secondary Color</label>
                    <input type="color" name="secondary_color" id="secondary_color" class="appearance-form-control" value="{{ $appearanceSettings->secondary_color }}" required>
                    <span class="color-box" id="secondary_color_box" style="background-color: {{ $appearanceSettings->secondary_color }}"></span>
                </div>
                <div class="appearance-form-group">
                    <label for="text_color">Text Color</label>
                    <input type="color" name="text_color" id="text_color" class="appearance-form-control" value="{{ $appearanceSettings->text_color }}" required>
                    <span class="color-box" id="text_color_box" style="background-color: {{ $appearanceSettings->text_color }}"></span>
                </div>
                <div class="appearance-form-group">
                    <label for="logo">Logo</label>
                    <input type="file" name="logo" id="logo" class="appearance-form-control">
                    @if($appearanceSettings->logo_path)
                        <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="Logo" class="appearance-logo-preview">
                    @endif
                </div>                
                <button type="submit" class="appearance-btn-primary">Save Appearance</button>
            </form>
        </div>
    </div>

    <!-- Features Settings Section -->
    <div class="customize-section">
        <h2>Features Settings</h2>
        <form action="{{ route('barangay_captain.features_settings.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Available Features</label>
                <div class="features-list">
                    @foreach($features as $feature)
                        <label>
                            <input type="checkbox" name="features[{{ $feature->id }}]" value="1" 
                            {{ in_array($feature->id, $selectedFeatures) ? 'checked' : '' }}>
                            {{ $feature->label }}
                        </label>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn-primary">Save Features</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/barangay_captain/customize/bc-customize.js'])
@endsection
