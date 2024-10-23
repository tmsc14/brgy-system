<div class="bg-brown-primary p-2 m-4">
    <span class="text-brown-secondary fs-2 fw-bold">Resident Details</span>
    <div class="d-flex flex-column bg-brown-secondary p-2">
        <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
            <x-form-text-input id="registrationFirstName" wire:model="firstName"
                propertyName="firstName" label="First Name" type="text"
                placeholder="Enter your first name here." class="flex-grow-1" />
            <x-form-text-input id="registrationMiddleName" wire:model="middleName"
                propertyName="middleName" label="Middle Name" type="text"
                placeholder="Enter your middle name here." class="flex-grow-1" />
            <x-form-text-input id="registrationLastName" wire:model="lastName"
                propertyName="lastName" label="Last Name" type="text"
                placeholder="Enter your last name here." class="flex-grow-1" />
        </div>
        <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
            <x-form-select id="registrationGender" label="Gender" wire:model="gender"
                propertyName="gender" class="flex-grow-1">
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
            <x-form-text-input id="registrationDateOfBirth" wire:model="dateOfBirth"
                propertyName="dateOfBirth" label="Date of Birth" type="date"
                placeholder="Date of birth" class="flex-grow-1" />
        </div>
        <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
            <x-form-text-input id="registrationContactNumber" label="Contact Number"
                wire:model="contactNumber" propertyName="contactNumber" type="text"
                placeholder="Contact Number" class="flex-grow-1" />
        </div>
        <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
            <x-form-text-input id="registrationEthnicity" label="Ethnicity"
                wire:model="ethnicity" propertyName="ethnicity" type="text"
                class="flex-grow-1" />
            <x-form-text-input id="registrationReligion" label="Religion" wire:model="religion"
                propertyName="religion" type="text" class="flex-grow-1" />
        </div>
        <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
            <x-form-select id="registrationCivilStatus" label="Civil Status"
                wire:model="civil_status" propertyName="civil_status"
                class="flex-grow-1">
                <option value="Married">
                    Married
                </option>
                <option value="Single">
                    Single
                </option>
                <option value="Divorced">
                    Divorced
                </option>
                <option value="Widowed">
                    Widowed
                </option>
            </x-form-select>
        </div>
        <div class="d-flex flex-column justify-content-around gap-3 flex-xl-row">
            <div class='me-auto'>
                <div>
                    <span>Are you a PWD?</span>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_pwd" id="registrationPwd1"
                        value="1" wire:model="is_pwd">
                    <label class="form-check-label" for="registrationPwd1">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_pwd" id="registrationPwd2"
                        value="0" wire:model="is_pwd">
                    <label class="form-check-label" for="registrationPwd2">
                        No
                    </label>
                </div>
                @error('is_pwd')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class='me-auto'>
                <div>
                    <span>Resident Status</span>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_temporary_resident"
                        id="registrationTemporaryResident1" value="1"
                        wire:model="is_temporary_resident">
                    <label class="form-check-label" for="registrationTemporaryResident1">
                        Temporary Resident
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_temporary_resident"
                        id="registrationTemporaryResident2" value="0"
                        wire:model="is_temporary_resident">
                    <label class="form-check-label" for="registrationTemporaryResident2">
                        Permanent Resident
                    </label>
                </div>
                @error('is_temporary_resident')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="d-flex flex-column justify-content-around gap-3 flex-xl-row">
            <div class="me-auto">
                <div>
                    <span>Are you a registered voter?</span>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_voter" id="registrationVoter1"
                        value="1" wire:model="is_voter">
                    <label class="form-check-label" for="registrationVoter1">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_voter" id="registrationVoter2"
                        value="0" wire:model="is_voter">
                    <label class="form-check-label" for="registrationVoter2">
                        No
                    </label>
                </div>
                @error('is_voter')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="me-auto">
                <div>
                    <span>Are you employed?</span>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_employed"
                        id="registrationEmployed1" value="1"
                        wire:model="is_employed">
                    <label class="form-check-label" for="registrationEmployed1">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_employed"
                        id="registrationEmployed2" value="0"
                        wire:model="is_employed">
                    <label class="form-check-label" for="registrationEmployed2">
                        No
                    </label>
                </div>
                @error('is_employed')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <hr class="text-brown-primary" />
        <button class="btn btn-primary-brown ms-auto" wire:click="save">
            Save
        </button>
    </div>
</div>
