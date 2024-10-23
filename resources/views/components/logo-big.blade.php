<img src="{{ asset(
    $appearanceSettings && $appearanceSettings->logo_path
        ? 'storage/' . $appearanceSettings->logo_path
        : 'resources/img/default-logo.png',
) }}"
    class="picture-header img-fluid rounded-circle" alt="Barangay Logo">
