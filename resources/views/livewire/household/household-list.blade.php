<div>
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-cottage class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Households ({{ $households->total() }})</x-title>
            <button class='btn btn-success ms-auto' wire:click='addResident'>Add Resident</button>
        </div>
        @error('resident')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
        <table class="table bg-brown-primary">
            <thead>
                <tr>
                    <th class="bg-brown-primary text-brown-secondary">NAME</th>
                    <th class="bg-brown-primary text-brown-secondary">ADDRESS</th>
                    <th class="bg-brown-primary text-brown-secondary">NO. OF RESIDENTS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($households as $household)
                    <tr>
                        <td class="brgy-bg-theme">{{ $household->head->first_name . ' ' . $household->head->last_name }}
                        </td>
                        <td class="brgy-bg-theme">{{ $household->street_address }}</td>
                        <td class="brgy-bg-theme">{{ $household->residents->count() }}</td>
                        <td class="brgy-bg-theme list-btn-cell">
                            <div class="list-btn-container">
                                <button wire:click='delete({{ $household->id }})' class="btn btn-danger">Delete</button>
                                <button wire:click='edit({{ $household->id }})' class="btn btn-warning">Edit</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-container>
</div>
