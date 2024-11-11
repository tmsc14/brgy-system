<div>
    <x-icon-header text="Settings" iconName="settings" />
    <ul class="nav nav-tabs brgy-nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link" href="/settings/staff">Profile</a>
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
                @if ($_user_role == 'Captain')
                    <form wire:submit="turnover">
                        <x-subtitle>Account Turnover</x-subtitle>
                        <div>This will assign a new Barangay Captain.</div>
                        <x-form-text-input class="mb-2" id="settings-account-turnover-email"
                            label="Email of New Captain:" wire:model="new_captain_email"
                            propertyName="new_captain_email" type="text" placeholder="Email of New Captain" />
                        <x-form-text-input class="mb-2" id="settings-turnover-current-password" label="Your Password:"
                            wire:model="captain_password" propertyName="captain_password" type="password"
                            placeholder="Your Password" />
                        <x-container-content-footer>
                            <div class="d-flex">
                                <button type="button" class="ms-auto btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#turnover-modal">Confirm</button>
                            </div>
                        </x-container-content-footer>

                        {{-- Modal --}}
                        <div class="modal fade" id="turnover-modal" tabindex="-1"
                            aria-labelledby="turnover-modal-label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="turnover-modal-label">Account Turnover
                                            Confirmation</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        This account will now turnover it's access as System administrator and the
                                        existing account will revert into a regular staff member.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Go
                                            Back</button>
                                        <button type="submit" class="btn btn-success"
                                            data-bs-dismiss="modal">Proceed</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </x-container-content>
    </x-container>

</div>
