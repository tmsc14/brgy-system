@extends('layouts.role_dashboard')

@section('sidebar')
@include('layouts.partials.sidebar_barangay_official')
@endsection

@section('content')
<x-icon-header
    text="Documents"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />
<x-icon-long-button
    text="RESIDENT DOCUMENT REQUESTS"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo-inactive.png'
    onClick="window.location='{{ route('barangay_official.documents.list') }}'" />
@endsection

@section('styles')
@vite(['resources/css/barangay_official/documents/bo-documents.css',
'resources/css/components/icon-long-button.css',
'resources/css/components/icon-header.css'
])
@endsection