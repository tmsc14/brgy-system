@extends('layouts.role_dashboard')

@section('sidebar')
@include('layouts.partials.sidebar_resident')
@endsection

@php
$queryParams = get_defined_vars()['__data'];
$jsonData = json_encode(array_filter($queryParams, function($key) {
        return !in_array($key, ['__env', 'app', 'appearanceSettings', 'barangay', 'errors', 'loop', 'request', 'user']); // Exclude unwanted variables
    }, ARRAY_FILTER_USE_KEY));

// Wrap the JSON data in a 'data' key
$dataToSend = json_encode(['data' => json_decode($jsonData)]); // Decode and re-encode to maintain structure
@endphp

@section('content')
<x-icon-header
    text="Documents / Request"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />
<div class="document-preview">
    <h2 class="preview-header">
        {{ strtoupper($documentType->getDescription()) }}
    </h2>
    <div class="document-preview-content">
        @include('document_templates.certificate-of-residency')
    </div>
    <div class="document-preview-button-footer">
        <button class="document-preview-back-btn">
            Back
        </button>
        <button
            class="document-preview-request-btn"
            onclick="sendRequest('/api/document', {{ $dataToSend }})">
            Request
        </button>
    </div>
</div>

<script>
    function sendRequest(url, data) {
        fetch(url, {
            method: 'POST', // Use POST method
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': '{{ csrf_token() }}', // Include CSRF token for Laravel
            },
            body: JSON.stringify(data) // Convert data to JSON
        })
        .then(response => {
            if (response.ok) {
                // If the response is successful, redirect to the success page
                return response.json(); // Assuming you return a JSON response
            } else {
                throw new Error(response.json);
            }
        })
        .then(data => {
            // Assuming you want to redirect to a success page
            // You may need to build the success URL based on the response or data
            window.location.href = '{{ route('barangay_resident.documentrequests.' . strtolower($documentType->name) . '.success') }}';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
@endsection

@section('styles')
@vite([
'resources/css/barangay_resident/documents/br-documents-preview.css',
'resources/css/components/icon-header.css'
])
@endsection