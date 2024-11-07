@php
    use App\Enums\Documents\DocumentType;
@endphp

<div>
    <x-container title="Document Requests" iconName="description">
        <x-paginate-table :records="$documentRequests">
            <thead>
                <tr>
                    <th></th>
                    <th>NAME</th>
                    <th>TYPE OF DOCUMENT</th>
                    <th>DATE</th>
                    <th>ACTION</th>
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
                            <div>
                                <button class="btn btn-danger">Deny</button>
                                <button wire:click="preview({{$documentRequest->id}})" class="btn btn-success">Print</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-paginate-table>
    </x-container>
</div>
