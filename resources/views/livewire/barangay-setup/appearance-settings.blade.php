<form wire:submit="save">
    <x-title spaced>Appearance Settings</x-title>
    @csrf
    <div class="d-flex flex-column gap-3">
        <x-form-select id="appearanceSettingTheme" label="Theme" wire:model.live="theme" propertyName="theme">
            <option value="custom">Custom</option>
            <option value="default">Default</option>
            <option value="dark">Dark</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </x-form-select>
        <div class="form-group">
            <label for="theme_color">Theme Color</label>
            <input type="color" name="theme_color" id="theme_color" class="form-control"
                wire:model.live="theme_color" />
            <span class="color-box" id="theme_color_box"
                style="background-color: {{ $appearanceSettings->theme_color ?? '#FAEED8' }}"></span>
        </div>
        <div class="form-group">
            <label for="primary_color">Primary Color</label>
            <input type="color" name="primary_color" id="primary_color" class="form-control"
                wire:model.live="primary_color" />
        </div>
        <div class="form-group">
            <label for="secondary_color">Secondary Color</label>
            <input type="color" name="secondary_color" id="secondary_color" class="form-control"
                wire:model.live="secondary_color" />
        </div>
        <div class="form-group">
            <label for="content_color">Content Color</label>
            <input type="color" name="content_color" id="content_color" class="form-control"
                wire:model.live="content_color" />
        </div>
        {{-- <div class="form-group">
            <label for="text_color">Text Color</label>
            <input type="color" name="text_color" id="text_color" class="form-control" wire:model.live="text_color"
                required>
        </div> --}}
        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" wire:model="logo">
            @if ($appearanceSettings->logo_path)
                <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="Logo"
                    class="img-fluid preview-image">
            @endif
            @error('logo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <hr class="line text-brown-primary" />
    <div class="d-flex justify-content-around">
        <button class="btn {{ $is_wizard_step ? 'btn-primary-brown' : 'btn-secondary-brgy' }} ms-auto" type="submit">
            Save
        </button>
    </div>
</form>
