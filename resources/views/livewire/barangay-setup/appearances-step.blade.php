<x-wizard-content-container>
    <form wire:submit="save">
        @csrf
        <div class="d-flex gap-4 mb-4 flex-column flex-xl-row justify-content-around">
            @foreach ($steps as $step)
                <div>
                    @if ($step->isCurrent())
                        <span class="fs-4 text text-primary fw-bold">
                            {{ $step->order }}. {{ $step->label }}
                        </span>
                    @else
                        <a wire:click="showStep('{{ $step->step_name }}')" class="fs-4 text text-brown-primary"
                            href="#">
                            {{ $step->order }}. {{ $step->label }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <h2>Appearance Settings</h2>
        @csrf
        {{-- <div class="form-group">
            <label for="theme">Select Theme</label>
            <select name="theme" id="theme" class="appearance-form-control">
                <option value="default" {{ $appearanceSettings->theme_color == '#FAEED8' ? 'selected' : '' }}>Default</option>
                <option value="dark" {{ $appearanceSettings->theme_color == '#2E2E2E' ? 'selected' : '' }}>Dark</option>
                <option value="blue" {{ $appearanceSettings->theme_color == '#E3F2FD' ? 'selected' : '' }}>Blue</option>
                <option value="green" {{ $appearanceSettings->theme_color == '#E8F5E9' ? 'selected' : '' }}>Green</option>
            </select>
        </div> --}}
        <x-form-select id="appearanceSettingTheme" label="Theme" wire:model.live="theme" propertyName="theme">
            <option value="custom">Custom</option>
            <option value="default">Default</option>
            <option value="dark">Dark</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
        </x-form-select>
        <div class="form-group">
            <label for="theme_color">Theme Color</label>
            <input type="color" name="theme_color" id="theme_color" class="form-control" wire:model.live="theme_color" />
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
            <label for="text_color">Text Color</label>
            <input type="color" name="text_color" id="text_color" class="form-control" wire:model.live="text_color"
                required>
        </div>
        <div class="form-group">
            <label for="logo">Logo</label>
            <input type="file" name="logo" id="logo" class="form-control" wire:model="logo">
            @if ($appearanceSettings->logo_path)
                <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" alt="Logo" class="img-fluid preview-image">
            @endif
        </div>
        <hr class="line text-brown-primary" />
        <div class="d-flex justify-content-around">
            <button class="btn btn-primary-brown ms-auto" type="submit">
                Save
            </button>
        </div>
    </form>
</x-wizard-content-container>
