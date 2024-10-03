@extends('layouts.role_dashboard')

@section('sidebar')
@include('layouts.partials.sidebar_resident')
@endsection

@section('content')
<x-icon-header
    text="Documents / Request"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />
<div class="document-request-success-banner">
    <h3>
        Your request for printing of a
    </h3>
    <h1>
        {{ strtoupper($documentType) }}
    </h1>
    <h3>
        is confirmed! Kindly proceed to your Barangay Hall for claiming.
</h3>
</div>
<h1 class="document-request-success-reminder-header">
    IMPORTANT REMINDERS!
</h1>
<div class="document-request-success-reminders">
    <ul>
        <li>Prepare the amount (###) for the Certification Fee.</li>
        <li>Proceed to the Barangay Hall Brgy. Secretary to claim your printed document.</li>
        <li>Present your Barangay Resident Account upon claiming.</li>
        <li>Office hours are between 9:00 am - 5:00 pm, every Sunday to Saturday.</li>
    </ul>
</div>
@endsection

@section('styles')
@vite([
'resources/css/barangay_resident/documents/br-documents-success.css',
'resources/css/components/icon-header.css'
])
@endsection