@php
    use App\Enums\Documents\DocumentType;
@endphp

<div>
    <x-icon-header text="Documents" iconName='description' />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Requests</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/documents/requests/history">History</a>
        </li>
    </ul>

    <x-container titleName="Document Requests" iconName="description">
        <x-paginate-table :records="$documentRequests">
            <thead>
                <tr>
                    <th></th>
                    <th>NAME</th>
                    <th>TYPE OF DOCUMENT</th>
                    <th>DATE REQUESTED</th>
                    <th>{{ $userLoggedInAs === 'staff' ? 'ACTION' : 'STATUS' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentRequests as $documentRequest)
                    <tr>
                        <td></td>
                        <td>{{ $documentRequest->name }}</td>
                        <td>{{ DocumentType::from($documentRequest->document_type)->getDescription() }}</td>
                        <td>{{ $documentRequest->created_at }}</td>
                        <td>
                            @if ($userLoggedInAs === 'staff')
                                <div>
                                    <button wire:click="deny({{ $documentRequest->id }})"
                                        class="btn btn-danger">Deny</button>
                                    <button wire:click="preview({{ $documentRequest->id }})"
                                        class="btn btn-success">Print</button>
                                </div>
                            @else
                                <label class="badge bg-warning">Pending</label>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-paginate-table>
        <a href="/documents" wire.navigate>
            <button class="btn btn-secondary-brgy">Back</button>
        </a>
    </x-container>
</div>
