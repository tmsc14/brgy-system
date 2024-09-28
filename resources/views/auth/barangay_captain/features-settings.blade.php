@extends('layouts.create-barangay')

@section('title', 'Features Settings')

@section('css')
    @vite(['resources/css/barangay_captain/create_barangay/features_settings.css'])
@endsection

@section('content')
<div class="features-settings-container">
    <form action="{{ route('barangay_captain.features_settings.post') }}" method="POST">
        @csrf

        <!-- Features and Permissions Section -->
        <div class="features-permissions-grid">
            <!-- Statistics and Demographics -->
            <div class="feature-category">
                <h3>Statistics and Demographics:</h3>
                @foreach($features as $feature)
                    @if($feature->category === 'statistics')
                        <label class="compact-label">
                            <span>{{ $feature->label }}</span>
                            <input type="checkbox" name="features[statistics][{{ $feature->id }}]" value="1"
                            {{ in_array($feature->id, $enabledFeatures) ? 'checked' : '' }}>
                        </label>
                    @endif
                @endforeach
            </div>

            <!-- Page Permissions -->
            <div class="permissions-category">
                <h3>Statistics Page Permissions:</h3>
                <div class="role-permissions-grid">
                    <div class="role-title"></div>
                    <div class="permission-title">View</div>
                    <div class="permission-title">Edit</div>
                    
                    <div class="role-title">Officials</div>
                    <input type="checkbox" name="permissions[officials][statistics][view]" value="1"
                    {{ isset($officialsPermissions[$statisticsFeatureId]) && $officialsPermissions[$statisticsFeatureId]->can_view ? 'checked' : '' }}>
                    <input type="checkbox" name="permissions[officials][statistics][edit]" value="1"
                    {{ isset($officialsPermissions[$statisticsFeatureId]) && $officialsPermissions[$statisticsFeatureId]->can_edit ? 'checked' : '' }}>
                    
                    <div class="role-title">Staff</div>
                    <input type="checkbox" name="permissions[staff][statistics][view]" value="1"
                    {{ isset($staffPermissions[$statisticsFeatureId]) && $staffPermissions[$statisticsFeatureId]->can_view ? 'checked' : '' }}>
                    <input type="checkbox" name="permissions[staff][statistics][edit]" value="1"
                    {{ isset($staffPermissions[$statisticsFeatureId]) && $staffPermissions[$statisticsFeatureId]->can_edit ? 'checked' : '' }}>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary">Save Settings</button>
    </form>
</div>
@endsection
