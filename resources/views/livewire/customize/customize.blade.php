<div>
    <x-icon-header text="Customize" iconResourcePath='resources/img/sidebar-icons/documents-sblogo.png' />
    <div class="d-flex flex-column gap-3">
        <x-container>
            <livewire:barangay-setup.barangay-information />
        </x-container>
        <x-container>
            <livewire:barangay-setup.appearance-settings is_wizard_step='true' />
        </x-container>
    </div>
</div>
