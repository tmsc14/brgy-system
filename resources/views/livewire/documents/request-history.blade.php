@php
    use App\Enums\Documents\DocumentType;
@endphp

<div>
    <x-icon-header text="Documents" iconName='description' />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="/documents/requests">Requests</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">History</a>
        </li>
    </ul>

    <x-container titleName="Document Requests History" iconName="description">
        <x-paginate-table :records="$documentRequests">
            <thead>
                <tr>
                    <th></th>
                    <th>NAME</th>
                    <th>TYPE OF DOCUMENT</th>
                    <th>DATE CREATED</th>
                    <th>DATE LAST UPDATED</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documentRequests as $documentRequest)
                    <tr>
                        <td></td>
                        <td>{{ $documentRequest->name }}</td>
                        <td>{{ DocumentType::from($documentRequest->document_type)->getDescription() }}</td>
                        <td>{{ $documentRequest->created_at }}</td>
                        <td>{{ $documentRequest->updated_at }}</td>
                        <td><span
                                class="badge {{ match ($documentRequest->status) {
                                    'Released' => 'bg-success',
                                    'Pending' => 'bg-warning',
                                    'Denied' => 'bg-danger',
                                    default => 'bg-secondary',
                                } }}">{{ $documentRequest->status }}</span>
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
