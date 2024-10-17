<div class="bg-brown-primary p-2 m-4 rounded">
    <div class='d-flex justify-content-between'>
        <h2 class="text-brown-secondary">Household</h2>
        <button class='btn btn-success' wire:click='addResident'>Add Resident</button>
    </div>
    @error('resident')
        <span class='text-danger'>{{ $message }}</span>
    @enderror
    <table class="table bg-brown-primary">
        <thead>
            <tr>
                <th class="bg-brown-primary text-brown-secondary">NAME</th>
                <th class="bg-brown-primary text-brown-secondary">DATE OF BIRTH</th>
                <th class="bg-brown-primary text-brown-secondary">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($residentsList as $resident)
                <tr>
                    <td class="bg-brown-secondary">{{ $resident->first_name . ' ' . $resident->last_name }}</td>
                    <td class="bg-brown-secondary">{{ $resident->date_of_birth }}</td>
                    <td class="bg-brown-secondary list-btn-cell">
                        <div class="list-btn-container">
                            <button wire:click='delete({{ $resident->id }})'
                                class="btn btn-danger">Delete</button>
                            <button wire:click='edit({{ $resident->id }})'
                                class="btn btn-warning">Edit</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
