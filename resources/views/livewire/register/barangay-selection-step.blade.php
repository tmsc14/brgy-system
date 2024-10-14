<div class="d-flex flex-column align-items-center w-100">
    <h2 class="text-brown-secondary">Register Barangay</h2>
    @csrf
    <div class="d-flex flex-column gap-3 w-100">
        <x-form-select
        name="region"
        label="Region"
        wire:model.live="selectedRegionCode"
        propertyName="selectedRegionCode"
        :options='$regions'
        optionValueKey="regCode"
        optionLabelKey="regDesc" />
    <x-form-select
        name="province"
        label="Province"
        wire:model.live="selectedProvinceCode"
        propertyName="selectedProvinceCode"
        :options='$provinces'
        optionValueKey="provCode"
        optionLabelKey="provDesc" />
    <x-form-select
        name="city"
        label="City / Municipality"
        wire:model.live="selectedCityCode"
        propertyName="selectedCityCode"
        :options='$cities'
        optionValueKey="citymunCode"
        optionLabelKey="citymunDesc" />
    <x-form-select
        name="barangay"
        label="Barangay"
        wire:model.live="selectedBarangayCode"
        propertyName="selectedBarangayCode"
        :options='$barangays'
        optionValueKey="brgyCode"
        optionLabelKey="brgyDesc" />
        <hr class="line text-brown-secondary" />
    <button class="btn btn-primary-brown w-25 ms-auto" wire:click="goToNextStep">Next Step</button>
</div>
</div>
