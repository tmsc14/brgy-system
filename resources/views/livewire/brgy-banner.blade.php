<div class="d-flex bg-light-blue rounded w-100 p-4 gap-4">
    <x-logo-big />
    <div class="d-flex flex-column align-self-center">
        <span
            class="big-header fw-bold">{{ 'Barangay' . ' ' . Auth::user()->barangay->display_name }}</span>
        <span class="fs-3">{{ $cityName . ', ' . $provinceName }}</span>
    </div>
    <div class="d-flex flex-column-reverse ms-auto">
        <span class="fs-3">{{ $householdCount . ' Households' }}</span>
    </div>
</div>