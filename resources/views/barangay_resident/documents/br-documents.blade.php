@extends('layouts.role_dashboard')

@section('sidebar')
@include('layouts.partials.sidebar_resident')
@endsection

@section('content')
<x-icon-header
    text="Documents / Request"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />
<x-content-container
    headerText="REQUEST"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo-inactive.png'
    class="light-brown">
    <div class="document-types-container">
        @foreach($documentRequestTypes as $type)
        <div class="document-type-entry">
            <div class="type-name">
                {{ $type->getDescription() }}
            </div>
            <button
                class="request-btn"
                onclick="window.location='{{ route('barangay_resident.documentrequests.' . strtolower($type->name)) }}'">Request</button>
        </div>
        @endforeach
    </div>
</x-content-container>
@endsection

@section('styles')
@vite([
'resources/css/barangay_resident/documents/br-documents.css',
'resources/css/components/icon-header.css',
'resources/css/components/content-container.css'
])
@endsection