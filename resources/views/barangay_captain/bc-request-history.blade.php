@extends('layouts.bc-template-dashboard')

@section('content')
    @vite(['resources/css/barangay_captain/bc-request-history.css'])

    <div class="history-container">
        <h2>Signup Requests History</h2>
        @if($requests->isEmpty())
            <p>No signup requests history available.</p>
        @else
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->first_name }} {{ $request->middle_name }} {{ $request->last_name }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $request->user_type)) }}</td>
                            <td>{{ ucfirst($request->status) }}</td>
                            <td>{{ $request->updated_at->format('F d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <a href="{{ route('bc-requests') }}" class="back-to-requests">Back to Requests</a>
    </div>
@endsection

@section('styles')
<style>
    :root {
        --theme-color: {{ $appearanceSettings->theme_color ?? '#e6f2ff' }};
        --primary-color: {{ $appearanceSettings->primary_color ?? '#0056b3' }};
        --secondary-color: {{ $appearanceSettings->secondary_color ?? '#ffffff' }};
        --text-color: {{ $appearanceSettings->text_color ?? '#000000' }};
    }
</style>
@endsection
