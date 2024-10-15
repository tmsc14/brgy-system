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
                        <a wire:click="showStep('{{ $step->step_name }}')" class="fs-4 text text-brown-primary" href="#">
                            {{ $step->order }}. {{ $step->label }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        {{-- <div class="form-group">
        <label for="barangay_name">Barangay Name/Title:</label>
        <input type="text" name="barangay_name" id="barangay_name"
            value="{{ old('barangay_name', $barangay->barangay_name ?? $geographicData['barangayDesc']) }}" required
            readonly>
    </div> --}}
        <div class="mb-4">
            <h3 class="text-brown-primary fw-bold">Barangay Information</h3>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="barangayInformationName" label="Barangay Name/Title" wire:model="display_name"
                    propertyName="display_name" type="text" class="flex-grow-1" />
                <x-form-text-input id="barangayInformationEmail" label="Barangay Email" wire:model="email"
                    propertyName="email" type="text" class="flex-grow-1" />
            </div>
        </div>
        <h3 class="text-brown-primary fw-bold">Barangay Complete Address</h3>
        <div class="d-flex flex-column justify-content-center gap-3">
            <x-form-text-input id="barangayInformationLineOne" label="Line 1" wire:model="address_line_one"
                propertyName="address_line_one" type="text" />
            <x-form-text-input id="barangayInformationLineTwo" label="Line 2" wire:model="address_line_two"
                propertyName="address_line_two" type="text" />
            <x-form-text-input id="barangayInformationOfficeAddress" label="Barangay Office Address"
                wire:model="barangay_office_address" propertyName="barangay_office_address" type="text" />
            <x-form-text-input id="barangayInformationDescription" label="Barangay Description" wire:model="description"
                propertyName="description" type="text" />
            <x-form-text-input id="barangayInformationContactNumber" label="Barangay Contact Number"
                wire:model="contact_number" propertyName="contact_number" type="text" />
        </div>
        <hr class="line text-brown-primary" />
        <div class="d-flex justify-content-around">
            <button class="btn btn-primary-brown ms-auto" type="submit">
                Next
            </button>
        </div>
    </form>
</x-wizard-content-container>
