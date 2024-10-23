<div class="d-flex justify-content-center mb-2 sidebar-logo rounded-circle overflow-hidden">
    <img src="{{ asset(
        $appearanceSettings && $appearanceSettings->logo_path
            ? 'storage/' . $appearanceSettings->logo_path
            : 'resources/img/default-logo.png',
    ) }}"
        class="img-fluid object-fit-fill" alt="Barangay Logo" class="w-25 h-auto">
</div>
