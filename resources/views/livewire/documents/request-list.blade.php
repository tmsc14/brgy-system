<div>
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-description class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Resident Requests</x-title>
        </div>
        <table class="table brgy-bg-primary">
            <thead>
                <tr>
                    <th class="brgy-bg-primary brgy-primary-text">NAME</th>
                    <th class="brgy-bg-primary brgy-primary-text">TYPE OF DOCUMENT</th>
                    <th class="brgy-bg-primary brgy-primary-text">DATE</th>
                    <th class="brgy-bg-primary brgy-primary-text">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentRequests as $documentRequest)
                    <tr>
                        <td></td>
                        <td>{{ $documentRequest->document_owner_name }}</td>
                        <td>{{ DocumentType::from($documentRequest->document_type)->getDescription() }}</td>
                        <td>{{ $documentRequest->created_at }}</td>
                        <td class="list-btn-cell">
                            <div class="list-btn-container">
                                <button class="deny-btn list-entry-btn">Deny</button>
                                <button
                                    onclick="window.location='{{ route('barangay_official.documents.preview', ['id' => $documentRequest->id]) }}'"
                                    class="print-btn list-entry-btn">Print</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-container>
</div>
