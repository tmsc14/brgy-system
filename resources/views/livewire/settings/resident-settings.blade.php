<div>
    <x-icon-header text="Settings" iconName="settings" />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/settings/resident/account">Account</a>
        </li>
    </ul>

    <x-container titleName="Profile" iconName="settings">
        <x-container-content>
            <form wire:submit="updateProfile">
                <div class="col-12 col-lg-6">
                    <x-subtitle>Profile Details</x-subtitle>
                    <x-form-text-input class="mb-2" id="settings-profile-contact-number" label="Contact Number:"
                        wire:model="contact_number" propertyName="contact_number" type="text"
                        placeholder="Contact Number" />
                    <x-container-content-footer>
                        <div class="d-flex">
                            <button class="ms-auto btn btn-success">Save</button>
                        </div>
                    </x-container-content-footer>
                </div>
            </form>
            <form wire:submit="turnover">
                <div class="col-12 col-lg-6">
                    <x-subtitle>Head of Household Turnover</x-subtitle>
                    <x-form-select class="mb-2" id="settings-profile-head-of-household-select"
                        label="Head of Household:" wire:model.live="newHeadResidentId" propertyName="newHeadResidentId"
                        hideDefaultOption>
                        <option value="" selected>Select a household resident here</option>
                        @foreach ($household_residents as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </x-form-select>
                    @if ($show_fields)
                        <x-form-text-input class="mb-2" id="settings-account-email" label="New Email:"
                            wire:model="email" propertyName="email" type="text" placeholder="Email" />
                        <x-form-text-input class="mb-2" id="settings-account-new-password" label="New Password:"
                            wire:model="password" propertyName="password" type="password" placeholder="New Password" />
                        <x-form-text-input class="mb-2" id="settings-account-new-password-confirm"
                            label="Confirm New Password:" wire:model="password_confirmation"
                            propertyName="password_confirmation" type="password" placeholder="Confirm New Password" />
                    @endif
                    <x-container-content-footer>
                        <div class="d-flex">
                            <button class="ms-auto btn btn-success">Save</button>
                        </div>
                    </x-container-content-footer>
                </div>
            </form>
        </x-container-content>
    </x-container>
</div>
