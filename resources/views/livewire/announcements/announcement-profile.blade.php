<div>
    <x-icon-header iconName="feedback" text="Announcements" />
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-feedback class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Post</x-title>
        </div>
        <div class="brgy-bg-content p-2 brgy-content-text rounded">
            <form class="d-flex flex-column gap-2" wire:submit="save">
                <x-form-text-input id="announcement-title" wire:model="title" propertyName="title" label="Title"
                    type="text" placeholder="Enter the announcement's title here." />
                <div class="form-group">
                    <label for="announcement-content">Content</label>
                    <textarea class="form-control" id="announcement-content" rows="3" wire:model="body"></textarea>
                </div>
                <div class="form-group">
                    <label for="announcement-photo">Photo</label>
                    <input type="file" name="announcement-photo" id="announcement-photo" class="form-control"
                        wire:model.live="photo">
                    @if (isset($photo))
                        <img src="{{ $photo->temporaryUrl() }}" alt="Photo" class="img-fluid preview-image" />
                    @elseif (isset($photoUrl))
                        <img src="{{ $photoUrl }}" alt="Photo" class="img-fluid preview-image" />
                    @endif
                    @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button class="btn btn-primary-brgy" type="button" wire:click="cancel">Cancel</button>
                    @if (isset($announcement))
                        <button wire:loading.attr="disabled" class="btn btn-danger" type="button"
                            wire:click="delete">Delete</button>
                    @endif
                    <button wire:loading.attr="disabled" class="btn btn-success" type="submit">Save</button>
                </div>
            </form>
        </div>
    </x-container>
</div>
