<div class="d-flex flex-column align-items-center w-100">
    <h2 class="text-brown-secondary py-4">Register Barangay</h2>
    @csrf
    <div class="d-flex flex-column gap-3 w-100 bg-brown-secondary p-4 rounded">
        <div class="d-flex gap-4 mb-4 flex-column flex-xxl-row">
            @foreach($steps as $step)
            <div>
                @if ($step->isCurrent())
                    <span class="fs-4 text text-primary fw-bold">
                        {{ $step->order }}. {{ $step->label }}
                    </span>
                @else
                    <span 
                        class="fs-4 text text-brown-primary">
                        {{ $step->order }}. {{ $step->label }}
                    </span>
                @endif
            </div>
            @endforeach
        </div>
    <h3 class="text-brown-primary fw-bold">Select Barangay</h3>
    <x-form-select
        id="registrationRegion"
        label="Region"
        wire:loading.attr="disabled"
        wire:model.live.debounce.0ms="selectedRegionCode"
        propertyName="selectedRegionCode"
        :options='$regions'
        optionValueKey="regCode"
        optionLabelKey="regDesc" />
    <x-form-select
        id="registrationProvince"
        label="Province"
        wire:loading.attr="disabled"
        wire:model.live.debounce.0ms="selectedProvinceCode"
        wire:target="selectedRegionCode"
        propertyName="selectedProvinceCode"
        :options='$provinces'
        optionValueKey="provCode"
        optionLabelKey="provDesc" />
    <x-form-select
        id="registrationCity"
        label="City / Municipality"
        wire:loading.attr="disabled"
        wire:model.live.debounce.0ms="selectedCityCode"
        wire:target="selectedRegionCode, selectedProvinceCode"
        propertyName="selectedCityCode"
        :options='$cities'
        optionValueKey="citymunCode"
        optionLabelKey="citymunDesc" />
    <x-form-select
        id="registrationBarangay"
        label="Barangay"
        wire:loading.attr="disabled"
        wire:model.live.debounce.0ms="selectedBarangayCode"
        wire:target="selectedRegionCode, selectedProvinceCode, selectedCityCode"
        propertyName="selectedBarangayCode"
        :options='$barangays'
        optionValueKey="brgyCode"
        optionLabelKey="brgyDesc" />
    <hr class="line text-brown-primary" />
    <button 
        class="btn btn-primary-brown flex-grow-1 ms-auto" 
        wire:click="goToNextStep"
        wire:loading.attr="disabled"
        wire:target="selectedRegionCode, selectedProvinceCode, selectedCityCode, selectedBarangayCode, goToNextStep">
        Next Step
    </button>
    </div>
</div>
