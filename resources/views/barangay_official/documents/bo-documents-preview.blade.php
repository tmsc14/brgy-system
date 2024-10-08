@extends('layouts.role_dashboard')

@section('sidebar')
@include('layouts.partials.sidebar_barangay_official')
@endsection

@php
use Spatie\LaravelPdf\Facades\Pdf;
$queryParams = get_defined_vars()['__data'];
$jsonData = json_encode(array_filter($queryParams, function($key) {
        return !in_array($key, ['__env', 'app', 'appearanceSettings', 'barangay', 'errors', 'loop', 'request', 'user']); // Exclude unwanted variables
    }, ARRAY_FILTER_USE_KEY));

// Wrap the JSON data in a 'data' key
$dataToSend = json_encode(['data' => json_decode($jsonData)]); // Decode and re-encode to maintain structure
@endphp

@section('content')
<x-icon-header
    text="Documents / Request / {{ $fullName }} / View"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />
<div class="document-preview">
    <h2 class="preview-header">
        {{ strtoupper($documentType->getDescription()) }}
    </h2>
    <div class="document-preview-content">
        @include('document_templates.certificate-of-residency')
    </div>
    <div class="document-preview-button-footer">
        <button class="document-preview-back-btn"
            onclick="window.location='{{ route('barangay_official.documents.list') }}'">
            Back
        </button>
        <button
            class="document-preview-request-btn"
            onclick="window.location='{{ route('barangay_official.documents.print', ['id' => $requestId]) }}'">
            Print
        </button>
    </div>
</div>

<script>
</script>
@endsection

@section('styles')
@vite([
'resources/css/barangay_official/documents/bo-documents-preview.css',
'resources/css/components/icon-header.css'
])
@endsection