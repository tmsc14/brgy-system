@extends('layouts.bc-template-dashboard')

@section('styles')
    @vite(['resources/css/barangay_captain/settings/bc-settings.css'])
@endsection

@section('content')
    <div class="settings-container">
        <h2>Settings</h2>

        <div class="section">
            <h3>Account Management</h3>
            <p>Manage your barangay captain account settings and transfer access to a new captain.</p>
            <button class="btn-turnover" onclick="initiateTurnover()">Initiate Turnover</button>
        </div>

        <div class="section">
            <h3>Appearance Settings</h3>
            <p>Customize the look and feel of your dashboard.</p>
            <a href="{{ route('barangay_captain.appearance_settings') }}" class="btn-appearance">Customize Appearance</a>
        </div>

        <div class="section">
            <h3>System Settings</h3>
            <p>Adjust the settings for the system's functionality.</p>
            <a href="#" class="btn-system-settings">System Settings</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function initiateTurnover() {
            if (confirm('Are you sure you want to initiate a turnover process? This action is irreversible.')) {
                window.location.href = "{{ route('barangay_captain.show_turnover') }}";
            }
        }
    </script>
@endsection
