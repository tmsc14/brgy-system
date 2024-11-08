<div>
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-group class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Household Residents</x-title>
            <button class='btn btn-success ms-auto' wire:click='addResident'>Add Resident</button>
        </div>
        @error('resident')
            <span class='text-danger'>{{ $message }}</span>
        @enderror
        <x-paginate-table :records="$residentsList">
            <thead>
                <tr>
                    <th>NAME</th>
                    <th>DATE OF BIRTH</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($residentsList as $resident)
                    <tr>
                        <td>{{ $resident->first_name . ' ' . $resident->last_name }}</td>
                        <td>{{ $resident->date_of_birth }}</td>
                        <td>
                            <div class="list-btn-container">
                                <button wire:click='delete({{ $resident->id }})' class="btn btn-danger">Delete</button>
                                <button wire:click='edit({{ $resident->id }})' class="btn btn-warning">Edit</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-paginate-table>
        <table class="table bg-brown-primary">
        </table>
    </x-container>
</div>
