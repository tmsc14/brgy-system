<div>
    <x-icon-header text="Settings" iconName="settings" />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="/settings/resident">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="#">Account</a>
        </li>
    </ul>

    <x-container titleName="Account" iconName="settings">
        <x-container-content>
            <div class="col-12 col-lg-6">
                <form wire:submit="changeEmail">
                    <x-subtitle>Account Info</x-subtitle>
                    <x-form-text-input class="mb-2" id="settings-account-email" label="Email:" wire:model="email"
                        propertyName="email" type="text" placeholder="Email" />
                    <x-container-content-footer>
                        <div class="d-flex">
                            <button class="ms-auto btn btn-success">Save</button>
                        </div>
                    </x-container-content-footer>
                </form>

                <form wire:submit="changePassword">
                    <x-subtitle>Reset Password</x-subtitle>
                    <x-form-text-input class="mb-2" id="settings-account-current-password" label="Current Password:"
                        wire:model="current_password" propertyName="current_password" type="password"
                        placeholder="Current Password" />
                    <x-form-text-input class="mb-2" id="settings-account-new-password" label="New Password:"
                        wire:model="new_password" propertyName="new_password" type="password"
                        placeholder="New Password" />
                    <x-form-text-input class="mb-2" id="settings-account-new-password-confirm"
                        label="Confirm New Password:" wire:model="new_password_confirmation"
                        propertyName="new_password_confirmation" type="password" placeholder="Confirm New Password" />
                    <x-container-content-footer>
                        <div class="d-flex">
                            <button class="ms-auto btn btn-success">Save</button>
                        </div>
                    </x-container-content-footer>
                </form>
            </div>
        </x-container-content>
    </x-container>

</div>
