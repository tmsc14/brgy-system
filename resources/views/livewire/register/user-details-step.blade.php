<form wire:submit.prevent="register">
    <div class="d-flex flex-column align-items-center w-100">
        <h2 class="text-brown-secondary py-4">Register Barangay</h2>
        @csrf
        <div class="d-flex flex-column gap-3 w-100 bg-brown-secondary p-4 rounded">
            <div class="d-flex gap-4 mb-4 flex-column flex-xl-row">
                @foreach ($steps as $step)
                    <div>
                        @if ($step->isCurrent())
                            <span class="fs-3 text text-primary fw-bold">
                                {{ $step->order }}. {{ $step->label }}
                            </span>
                        @else
                            <span class="fs-3 text text-brown-primary">
                                {{ $step->order }}. {{ $step->label }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
            <h3 class="text-brown-primary fw-bold">Barangay Captain Details</h3>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationFirstName" wire:model="form.firstName" propertyName="form.firstName"
                    label="First Name" type="text" placeholder="Enter your first name here." class="flex-grow-1" />
                <x-form-text-input id="registrationMiddleName" wire:model="form.middleName"
                    propertyName="form.middleName" label="Middle Name" type="text"
                    placeholder="Enter your middle name here." class="flex-grow-1" />
                <x-form-text-input id="registrationLastName" wire:model="form.lastName" propertyName="form.lastName"
                    label="Last Name" type="text" placeholder="Enter your last name here." class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-select id="registrationGender" label="Gender" wire:model="form.gender"
                    propertyName="form.gender" class="flex-grow-1">
                    <option value="Male" {{ old('gender', session('gender')) == 'Male' ? 'selected' : '' }}>Male
                    </option>
                    <option value="Female" {{ old('gender', session('gender')) == 'Female' ? 'selected' : '' }}>Female
                    </option>
                    <option value="Other" {{ old('gender', session('gender')) == 'Other' ? 'selected' : '' }}>Other
                    </option>
                </x-form-select>
                <x-form-text-input id="registrationDateOfBirth" wire:model="form.dateOfBirth"
                    propertyName="form.dateOfBirth" label="Date of Birth" type="date" placeholder="Date of birth"
                    class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationContactNumber" label="Contact Number" wire:model="form.contactNumber"
                    propertyName="form.contactNumber" type="text" placeholder="Contact Number" class="flex-grow-1" />
            </div>
            <x-form-text-input id="registrationEmail" label="Email" wire:model="form.email" propertyName="form.email"
                type="text" />
            <x-form-password id="registerPassword" label="Password" propertyName="form.password"
                wire:model="form.password" />
            <x-form-password id="confirmPassword" label="Confirm Password" propertyName="form.password_confirmation"
                wire:model="form.password_confirmation" />
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <div class="form-group flex-grow-1">
                    <label for="registrationValidId" class="text-brown-primary">Valid I.D.</label>
                    <input class="form-control" type="file" id="registrationValidId" wire:model.live="form.validId">
                    @error('form.validId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <x-form-text-input id="registrationAccessCode" wire:model="form.accessCode"
                    propertyName="form.accessCode" label="Access Code" type="password" class="flex-grow-1" />
            </div>

            <!-- Terms and Conditions Section -->
            <div class="d-flex flex-column justify-content-center gap-3">
                <div>
                    <input type="checkbox" id="acceptTerms" required />
                    <label for="acceptTerms">
                        I agree to the
                        <span class="text-primary" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#termsModal">
                            Terms and Conditions
                        </span>.
                    </label>
                </div>
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
                            @include('terms-and-conditions') <!-- Include your terms content here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="line text-brown-primary" />
            <div class="d-flex justify-content-around">
                <button class="btn btn-link" wire:click="previousStep">Go back</button>
                <button class="btn btn-primary-brown ms-auto" type="submit">
                    Register
                </button>
            </div>
        </div>
    </div>
</form>
