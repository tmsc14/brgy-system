<form wire:submit="save">
    @csrf
    <div class="mb-4">
        <x-h3 :useDefaultStyle='$is_wizard_step'>Barangay Information</x-h3>
        <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
            <x-form-text-input id="barangayInformationName" label="Barangay Name/Title" wire:model="display_name"
                propertyName="display_name" type="text" class="flex-grow-1" :useDefaultStyle='$is_wizard_step' />
            <x-form-text-input id="barangayInformationEmail" label="Barangay Email" wire:model="email"
                propertyName="email" type="text" class="flex-grow-1" :useDefaultStyle='$is_wizard_step' />
        </div>
    </div>
    <x-h3 :useDefaultStyle='$is_wizard_step'>Barangay Complete Address</x-h3>
    <div class="d-flex flex-column justify-content-center gap-3">
        <x-form-text-input id="barangayInformationLineOne" label="Line 1" wire:model="address_line_one"
            propertyName="address_line_one" type="text" :useDefaultStyle='$is_wizard_step' />
        <x-form-text-input id="barangayInformationLineTwo" label="Line 2" wire:model="address_line_two"
            propertyName="address_line_two" type="text" :useDefaultStyle='$is_wizard_step' />
        <x-form-text-input id="barangayInformationContactNumber" label="Barangay Contact Number"
            wire:model="contact_number" propertyName="contact_number" type="text" :useDefaultStyle='$is_wizard_step' />
    </div>
    <x-hr />
    <div class="d-flex justify-content-around">
        <button class="btn {{ $is_wizard_step ? 'btn-primary-brown' : 'btn-secondary-brgy' }} ms-auto" type="submit">
            Save
        </button>
    </div>
</form>
