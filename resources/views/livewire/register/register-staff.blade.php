<x-login.card-with-logo>
    <hr class="line text-brown-secondary w-100" />
    <div class="wizard-container w-100">
        <form wire:submit="register">
            <div class="d-flex flex-column align-items-center w-100">
                <h2 class="text-brown-secondary py-4">Register Staff</h2>
                @csrf
                <div class="d-flex flex-column gap-3 w-100 bg-brown-secondary p-4 rounded">
                    <h3 class="text-brown-primary fw-bold">Staff Details</h3>
                    <x-form-select id="registrationBarangay" label="Barangay" wire:model="staffForm.selectedBarangayId"
                        propertyName="staffForm.selectedBarangayId" class="flex-grow-1">
                        @foreach ($barangayOptions as $option)
                            <option value="{{ $option['id'] }}">
                                {{ $option['barangay_name'] }}, {{ $option['city_name'] }}
                            </option>
                        @endforeach
                    </x-form-select>
                    <x-form-select id="registrationRole" label="Role" wire:model.live="role" propertyName="role"
                        class="flex-grow-1">
                        <option value="Official">
                            Official
                        </option>
                        <option value="Staff">
                            Staff
                        </option>
                    </x-form-select>
                    @if ($role === 'Official')
                        <x-form-select id="registrationPosition" label="Position"
                            wire:model.live="staffForm.officialPosition" propertyName="staffForm.officialPosition"
                            class="flex-grow-1">
                            <option value="Sangguniang Barangay Member">Sangguniang Barangay Member</option>
                            <option value="SK Chairperson">SK Chairperson</option>
                            <option value="Barangay Secretary">Barangay Secretary</option>
                        </x-form-select>
                    @elseif ($role === 'Staff')
                        <x-form-select id="registrationStaffRole" label="Staff Role"
                            wire:model.live="staffForm.staffRole" propertyName="staffForm.staffRole"
                            class="flex-grow-1">
                            <option value="Cashier">Cashier</option>
                            <option value="Clerk">Clerk</option>
                            <option value="Manager">Manager</option>
                        </x-form-select>
                    @endif
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <x-form-text-input id="registrationFirstName" wire:model="form.firstName"
                            propertyName="form.firstName" label="First Name" type="text"
                            placeholder="Enter your first name here." class="flex-grow-1" />
                        <x-form-text-input id="registrationMiddleName" wire:model="form.middleName"
                            propertyName="form.middleName" label="Middle Name" type="text"
                            placeholder="Enter your middle name here." class="flex-grow-1" />
                        <x-form-text-input id="registrationLastName" wire:model="form.lastName"
                            propertyName="form.lastName" label="Last Name" type="text"
                            placeholder="Enter your last name here." class="flex-grow-1" />
                    </div>
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <x-form-select id="registrationGender" label="Gender" wire:model="form.gender"
                            propertyName="form.gender" class="flex-grow-1">
                            <option value="Male" {{ old('gender', session('gender')) == 'Male' ? 'selected' : '' }}>
                                Male
                            </option>
                            <option value="Female" {{ old('gender', session('gender')) == 'Female' ? 'selected' : '' }}>
                                Female
                            </option>
                            <option value="Other" {{ old('gender', session('gender')) == 'Other' ? 'selected' : '' }}>
                                Other
                            </option>
                        </x-form-select>
                        <x-form-text-input id="registrationDateOfBirth" wire:model="form.dateOfBirth"
                            propertyName="form.dateOfBirth" label="Date of Birth" type="date"
                            placeholder="Date of birth" class="flex-grow-1" />
                    </div>
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <x-form-text-input id="registrationContactNumber" label="Contact Number"
                            wire:model="form.contactNumber" propertyName="form.contactNumber" type="text"
                            placeholder="Contact Number" class="flex-grow-1" />
                    </div>
                    <x-form-text-input id="registrationEmail" label="Email" wire:model="form.email"
                        propertyName="form.email" type="text" />
                    <x-form-password id="registerPassword" label="Password" propertyName="form.password"
                        wire:model="form.password" />
                    <x-form-password id="confirmPassword" label="Confirm Password"
                        propertyName="form.password_confirmation" wire:model="form.password_confirmation" />
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <div class="form-group flex-grow-1">
                            <label for="registrationValidId" class="text-brown-primary">Valid I.D.</label>
                            <input class="form-control" type="file" id="registrationValidId"
                                wire:model="form.validId">
                            @error('form.validId')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                     <!-- New Terms and Conditions Section -->
                     <div class="d-flex flex-column justify-content-center gap-3">
                        <div>
                            <input type="checkbox" id="acceptTerms" />
                            <label for="acceptTerms">
                                I agree to the
                                <span class="text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#termsModal">
                                    Terms and Conditions
                                </span>.
                            </label>
                        </div>
                    </div>

                    <!-- Existing Register Button -->
                    <hr class="line text-brown-primary" />
                    <div class="d-flex justify-content-around">
                        <button id="registerButton" class="btn btn-primary-brown ms-auto" type="submit" disabled>
                            Register
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @include('terms-and-conditions')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-login.card-with-logo>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('acceptTerms');
        const registerButton = document.getElementById('registerButton');

        checkbox.addEventListener('change', function () {
            registerButton.disabled = !this.checked;
        });
    });
</script>