@extends('layouts.role_dashboard')

@section('sidebar')
@include('layouts.partials.sidebar_barangay_official')
@endsection

@php
use App\Enums\Documents\DocumentType;
@endphp

@section('content')
<x-icon-header
    text="Documents / Resident Request"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />

<x-content-container
    headerText="RESIDENT REQUESTS"
    iconResourcePath='resources/img/sidebar-icons/documents-sblogo-inactive.png'>
    <table>
        <thead>
            <tr>
                <th />
                <th>NAME</th>
                <th>TYPE OF DOCUMENT</th>
                <th>DATE</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentRequests as $documentRequest)
            <tr>
                <td></td>
                <td>{{ $documentRequest->document_owner_name }}</td>
                <td>{{ DocumentType::from($documentRequest->document_type)->getDescription() }}</td>
                <td>{{ $documentRequest->created_at }}</td>
                <td class="list-btn-cell">
                    <div class="list-btn-container">
                        <button class="view-btn list-entry-btn">View</button>
                        <button class="deny-btn list-entry-btn">Deny</button>
                        <button onclick="window.location='{{ route('barangay_official.documents.preview', ['id' => $documentRequest->id]) }}'"  class="print-btn list-entry-btn">Print</button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-content-container>
@endsection

<script>
    function makeReadable(input) {
    // Split the string by underscores
    const words = input.split('_');
    
    // Capitalize the first letter of each word and join them with a space
    const readable = words.map(word => {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }).join(' ');
    
    return readable;
}
</script>

@section('styles')
@vite(['resources/css/barangay_official/documents/bo-documents.css', 
'resources/css/barangay_official/documents/bo-documents-request-list.css',
'resources/css/components/icon-header.css',
'resources/css/components/content-container.css'
])
@endsection