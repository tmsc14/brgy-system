<div>
    <x-icon-header text="Settings" iconName="settings" />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/settings/staff/account">Account</a>
        </li>
    </ul>

    <x-container titleName="Profile" iconName="settings">
        <x-container-content>
            <form wire:submit="save">
                <div class="col-12 col-lg-6">
                    <x-form-text-input class="mb-2" id="settings-profile-first-name" label="First Name:" wire:model="first_name"
                        propertyName="first_name" type="text" placeholder="First Name" />
                    <x-form-text-input class="mb-2" id="settings-profile-middle-name" label="Middle Name:" wire:model="middle_name"
                        propertyName="middle_name" type="text" placeholder="Middle Name" />
                    <x-form-text-input class="mb-2" id="settings-profile-last-name" label="Last Name:" wire:model="last_name"
                        propertyName="last_name" type="text" placeholder="Last Name" />
                    <x-form-text-input class="mb-2" id="settings-profile-date-of-birth" label="Date of Birth:" wire:model="date_of_birth"
                        propertyName="date_of_birth" type="date" placeholder="Date of Birth" />
                </div>
                <x-container-content-footer>
                    <div class="d-flex">
                        <button class="ms-auto btn btn-success">Save</button>
                    </div>
                </x-container-content-footer>
            </form>
        </x-container-content>
    </x-container>
</div>
