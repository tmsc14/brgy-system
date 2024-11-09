<div>
    <x-container>
        <div class="d-flex align-items-center">
            <x-gmdi-group class="bigger-icon brgy-primary-text me-1" />
            <x-title class="brgy-primary-text">Add Resident</x-title>
        </div>
        <div class="d-flex flex-column brgy-bg-content p-2">
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationFirstName" wire:model="firstName" propertyName="firstName"
                    label="First Name" type="text" placeholder="Enter your first name here." class="flex-grow-1" />
                <x-form-text-input id="registrationMiddleName" wire:model="middleName" propertyName="middleName"
                    label="Middle Name" type="text" placeholder="Enter your middle name here." class="flex-grow-1" />
                <x-form-text-input id="registrationLastName" wire:model="lastName" propertyName="lastName"
                    label="Last Name" type="text" placeholder="Enter your last name here." class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-select id="registrationGender" label="Gender" wire:model="gender" propertyName="gender"
                    class="flex-grow-1">
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
                <x-form-text-input id="registrationDateOfBirth" wire:model="dateOfBirth" propertyName="dateOfBirth"
                    label="Date of Birth" type="date" placeholder="Date of birth" class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationContactNumber" label="Contact Number" wire:model="contactNumber"
                    propertyName="contactNumber" type="text" placeholder="Contact Number" class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationEthnicity" label="Ethnicity" wire:model="ethnicity"
                    propertyName="ethnicity" type="text" class="flex-grow-1" />
                <x-form-text-input id="registrationReligion" label="Religion" wire:model="religion"
                    propertyName="religion" type="text" class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-select id="registrationCivilStatus" label="Civil Status" wire:model="civil_status"
                    propertyName="civil_status" class="flex-grow-1">
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
                <div class='checkbox-container flex-grow-1'>
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
                <div class='checkbox-container flex-grow-1'>
                    <div>
                        <span>Resident Status</span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_temporary_resident"
                            id="registrationTemporaryResident1" value="1" wire:model="is_temporary_resident">
                        <label class="form-check-label" for="registrationTemporaryResident1">
                            Temporary Resident
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_temporary_resident"
                            id="registrationTemporaryResident2" value="0" wire:model="is_temporary_resident">
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
                <div class="checkbox-container flex-grow-1">
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
                <div class="checkbox-container flex-grow-1">
                    <div>
                        <span>Are you employed?</span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_employed" id="registrationEmployed1"
                            value="1" wire:model="is_employed">
                        <label class="form-check-label" for="registrationEmployed1">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_employed" id="registrationEmployed2"
                            value="0" wire:model="is_employed">
                        <label class="form-check-label" for="registrationEmployed2">
                            No
                        </label>
                    </div>
                    @error('is_employed')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column justify-content-around gap-3 flex-xl-row">
                <div class="checkbox-container flex-grow-1">
                    <div>
                        <span>Is your birth registered with the Local Civil Registry Office?</span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_birth_registered"
                            id="registration-birth-registered-1" value="Yes" wire:model="is_birth_registered">
                        <label class="form-check-label" for="registration-birth-registered-1">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_birth_registered"
                            id="registration-birth-registered-2" value="No" wire:model="is_birth_registered">
                        <label class="form-check-label" for="registration-birth-registered-2">
                            No
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_birth_registered"
                            id="registration-birth-registered-3" value="Don't know" wire:model="is_birth_registered">
                        <label class="form-check-label" for="registration-birth-registered-3">
                            Don't know
                        </label>
                    </div>
                    @error('is_birth_registered')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="checkbox-container flex-grow-1">
                    <div>
                        <span>Can you read and write a simple message in any language or dialect?</span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_literate"
                            id="registration-literacy-1" value="1" wire:model="is_literate">
                        <label class="form-check-label" for="registration-literacy-1">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_literate"
                            id="registration-literacy-2" value="0" wire:model="is_literate">
                        <label class="form-check-label" for="registration-literacy-2">
                            No
                        </label>
                    </div>
                    @error('is_literate')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column justify-content-around gap-3 flex-xl-row">
                <div class="checkbox-container flex-grow-1">
                    <div>
                        <span>Are you a single parent?</span>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_single_parent" id="registrationSingleParent1"
                            value="1" wire:model="is_single_parent">
                        <label class="form-check-label" for="registrationSingleParent1">
                            Yes
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="is_single_parent" id="registrationSingleParent2"
                            value="0" wire:model="is_single_parent">
                        <label class="form-check-label" for="registrationVoter2">
                            No
                        </label>
                    </div>
                    @error('is_single_parent')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <hr class="text-brown-primary" />
            <button class="btn btn-primary-brown ms-auto" wire:click="save">
                Save
            </button>
        </div>
    </x-container>
</div>
