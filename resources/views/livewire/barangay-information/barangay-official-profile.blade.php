<div>
    <x-icon-header text="Barangay Officials" iconName="info" />
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-group class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Barangay Official</x-title>
        </div>
        <div class="brgy-bg-content p-2 brgy-content-text">
            <form class="d-flex flex-column gap-2" wire:submit="save">
                <x-subtitle>Add Barangay Official</x-subtitle>
                <x-form-text-input id="official-name" wire:model="name" propertyName="name" label="Name" type="text"
                    placeholder="Enter the official's name here." />
                <x-form-text-input id="official-contact-number" wire:model="contact_number"
                    propertyName="contact_number" label="Contact Number" type="text"
                    placeholder="Enter the official's contact number here." />
                <x-form-text-input id="official-title" wire:model="title" propertyName="title" label="Title"
                    type="text" placeholder="Enter the official's title here." />
                <x-form-select id="official-rank" label="Rank" wire:model="rank" propertyName="rank">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </x-form-select>
                <div class="form-group">
                    <label for="official-photo">Photo</label>
                    <input type="file" name="official-photo" id="official-photo" class="form-control"
                        wire:model="photo">
                    @if (isset($photo))
                        <img src="{{ $photo->temporaryUrl() }}" alt="Photo" class="img-fluid preview-image">
                    @endif
                    @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button class="btn btn-primary-brgy" type="button" wire:click="cancel">Cancel</button>
                    @if (isset($barangayOfficial))
                        <button class="btn btn-danger" type="button" wire:click="delete">Delete</button>
                    @endif
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </x-container>
</div>
