<div>
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-cottage class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Households ({{ $households->total() }})</x-title>
            <button class='btn btn-success ms-auto' wire:click='add'>Add Household</button>
        </div>
        @error('resident')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
        <x-paginate-table :records="$households">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>ADDRESS</th>
                    <th>NO. OF RESIDENTS</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($households as $household)
                    <tr>
                        <td>{{ $household->head->first_name . ' ' . $household->head->last_name }}
                        </td>
                        <td>{{ $household->street_address }}</td>
                        <td>{{ $household->residents->count() }}</td>
                        <td>
                            <div>
                                <button wire:click='delete({{ $household->id }})' class="btn btn-danger">Delete</button>
                                <button wire:click='edit({{ $household->id }})' class="btn btn-warning">Edit</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-paginate-table>
    </x-container>
</div>
