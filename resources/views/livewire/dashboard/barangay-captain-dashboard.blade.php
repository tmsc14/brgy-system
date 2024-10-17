<div>
    <div class="d-flex flex-column gap-4 p-4">
        <div class="d-flex bg-light-blue rounded w-100 p-2">
            @if ($appearanceSettings && $appearanceSettings->logo_path)
                <img src="{{ asset('storage/' . $appearanceSettings->logo_path) }}" class="w-25 img-fluid p-4"
                    alt="Barangay Logo">
            @else
                <img src="{{ asset('resources/img/default-logo.png') }}" class="picture-header w-25 img-fluid p-5"
                    alt="Default Barangay Logo">
            @endif
            <div class="d-flex flex-column align-self-center">
                <span
                    class="big-header text-brown-primary fw-bold">{{ 'Barangay' . ' ' . Auth::user()->barangay->display_name }}</span>
                <span class="fs-3 text-brown-primary">{{ $cityName . ', ' . $provinceName }}</span>
            </div>
            <div class="d-flex flex-column-reverse ms-auto">
                <span class="fs-3">{{ $householdCount . ' Households' }}</span>
            </div>
        </div>
        <div class="d-flex flex-column">
            <h3 class="text-muted">Requests</h3>
            <div class="d-flex">
                <div class="bg-light-brown p-4 col-4">
                    <div class="d-flex">
                        <span class="text-brown-secondary fs-3 fw-bold">Requests</span>
                        <button class="btn btn-link text-brown-secondary ms-auto"
                            wire:click="goToRequests">More</button>
                    </div>
                    <hr class="line text-brown-secondary" />
                    <div class="d-flex bg-light-green p-2">
                        @if ($demoRequesterName)
                            <div class="d-flex flex-column justify-content-start">
                                <span class="text-brown-secondary">Name</span>
                                <span class="fw-bold text-brown-secondary">{{ $demoRequesterName }}</span>
                                <span class="text-brown-secondary">{{ $demoRequesterRole }}</span>
                            </div>
                            <div class="d-flex flex-column justify-content-around ms-auto">
                                <img class="icon ms-auto"
                                    src="{{ asset('resources/img/sidebar-icons/admins-sblogo-inactive.png') }}"></img>
                                <span wire:click='goToRequests' class="text-brown-secondary ms-auto fs-5 fw-bold ">Accept</span>
                            </div>
                        @else
                            <span class="text-brown-secondary">No pending requests.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column">
            <h3 class="text-muted">Statistics</h3>
            <div class="d-flex flex-column justify-content-center align-items-center bg-white square p-4">
                <img src="{{ asset('resources/img/sidebar-icons/admins-sblogo.png') }}" alt="Residents Icon"
                    class="bigger-icon">
                <h3>Number of Residents</h3>
                <div class="fs-1 value text-primary">{{ $totalResidentsCount }}</div>
            </div>
        </div>
    </div>
</div>
