<x-login.card-with-logo>
    <hr class="line text-brown-secondary w-100" />
    <div class="wizard-container w-100">
        <form wire:submit="register">
            <div class="d-flex flex-column align-items-center w-100">
                <h2 class="text-brown-secondary py-4">Register Resident</h2>
                @csrf
                <div class="d-flex flex-column gap-3 w-100 bg-brown-secondary p-4 rounded">
                    <h3 class="text-brown-primary fw-bold">Resident Details</h3>
                    <x-form-select id="registrationBarangay" label="Barangay" wire:model="selectedBarangayId"
                        propertyName="selectedBarangayId" class="flex-grow-1">
                        @foreach ($barangayOptions as $option)
                            <option value="{{ $option['id'] }}">
                                {{ $option['barangay_name'] }}, {{ $option['city_name'] }}
                            </option>
                        @endforeach
                    </x-form-select>
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
                        <x-form-select id="registrationGender" label="Gender/Kasarian" wire:model="form.gender"
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
                            propertyName="form.dateOfBirth" label="Date of Birth/Petsa ng kapanganakan" type="date"
                            placeholder="Date of birth" class="flex-grow-1" />
                    </div>
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <x-form-text-input id="registrationContactNumber" label="Contact Number"
                            wire:model="form.contactNumber" propertyName="form.contactNumber" type="text"
                            placeholder="Contact Number" class="flex-grow-1" />
                        <x-form-text-input id="registrationStreetAddress" wire:model="residentForm.street_address"
                            propertyName="residentForm.street_address" label="Street Address" type="text"
                            placeholder="Enter your street address here." class="flex-grow-1" />
                        <hr />
                    </div>
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <x-form-text-input id="registrationEthnicity" label="Ethnicity/Lahi (Filipino, American, etc.)"
                            wire:model="residentForm.ethnicity" propertyName="residentForm.ethnicity" type="text"
                            class="flex-grow-1" />
                        <x-form-text-input id="registrationReligion" label="Religion/Relihiyon (Catholic, Islam, etc.)" wire:model="residentForm.religion"
                            propertyName="residentForm.religion" type="text" class="flex-grow-1" />
                    </div>
                    <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                        <x-form-select id="registrationCivilStatus" label="Civil Status/Katayuan ng sibil"
                            wire:model="residentForm.civil_status" propertyName="residentForm.civil_status"
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
                        <div class='checkbox-container flex-grow-1'>
                            <div>
                                <span>Are you a PWD?</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_pwd" id="registrationPwd1"
                                    value="1" wire:model="residentForm.is_pwd">
                                <label class="form-check-label" for="registrationPwd1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_pwd" id="registrationPwd2"
                                    value="0" wire:model="residentForm.is_pwd">
                                <label class="form-check-label" for="registrationPwd2">
                                    No
                                </label>
                            </div>
                            @error('residentForm.is_pwd')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class='checkbox-container flex-grow-1'>
                            <div>
                                <span>Resident Status / Kalagayan ng Tirahan</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_temporary_resident"
                                    id="registrationTemporaryResident1" value="1"
                                    wire:model="residentForm.is_temporary_resident">
                                <label class="form-check-label" for="registrationTemporaryResident1">
                                    Temporary Resident
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_temporary_resident"
                                    id="registrationTemporaryResident2" value="0"
                                    wire:model="residentForm.is_temporary_resident">
                                <label class="form-check-label" for="registrationTemporaryResident2">
                                    Permanent Resident
                                </label>
                            </div>
                            @error('residentForm.is_temporary_resident')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-around gap-3 flex-xl-row">
                        <div class="checkbox-container flex-grow-1">
                            <div>
                                <span>Are you a registered voter? / Naka rehitro magboto?</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_voter"
                                    id="registrationVoter1" value="1" wire:model="residentForm.is_voter">
                                <label class="form-check-label" for="registrationVoter1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_voter"
                                    id="registrationVoter2" value="0" wire:model="residentForm.is_voter">
                                <label class="form-check-label" for="registrationVoter2">
                                    No
                                </label>
                            </div>
                            @error('residentForm.is_voter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="checkbox-container flex-grow-1">
                            <div>
                                <span>Are you employed? / May Trabaho?</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_employed"
                                    id="registrationEmployed1" value="1" wire:model="residentForm.is_employed">
                                <label class="form-check-label" for="registrationEmployed1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_employed"
                                    id="registrationEmployed2" value="0" wire:model="residentForm.is_employed">
                                <label class="form-check-label" for="registrationEmployed2">
                                    No
                                </label>
                            </div>
                            @error('residentForm.is_employed')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-around gap-3 flex-xl-row">
                        <div class="checkbox-container flex-grow-1">
                            <div>
                                <span>Is your birth registered with the Local Civil Registry Office? / Naka rehistro ang pagsilang?</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_birth_registered"
                                    id="registration-birth-registered-1" value="Yes"
                                    wire:model="residentForm.is_birth_registered">
                                <label class="form-check-label" for="registration-birth-registered-1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_birth_registered"
                                    id="registration-birth-registered-2" value="No"
                                    wire:model="residentForm.is_birth_registered">
                                <label class="form-check-label" for="registration-birth-registered-2">
                                    No
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_birth_registered"
                                    id="registration-birth-registered-3" value="Don't know"
                                    wire:model="residentForm.is_birth_registered">
                                <label class="form-check-label" for="registration-birth-registered-3">
                                    Don't know
                                </label>
                            </div>
                            @error('residentForm.is_birth_registered')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="checkbox-container flex-grow-1">
                            <div>
                                <span>Can you read and write a simple message in any language or dialect? / Nakakapagsulat o nakakapagbasa?</span>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_literate"
                                    id="registration-literacy-1" value="1"
                                    wire:model="residentForm.is_literate">
                                <label class="form-check-label" for="registration-literacy-1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_literate"
                                    id="registration-literacy-2" value="0"
                                    wire:model="residentForm.is_literate">
                                <label class="form-check-label" for="registration-literacy-2">
                                    No
                                </label>
                            </div>
                            @error('residentForm.is_literate')
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
                                <input class="form-check-input" type="radio" name="is_single_parent"
                                    id="registration-single-parent-1" value="1"
                                    wire:model="residentForm.is_single_parent">
                                <label class="form-check-label" for="registration-single-parent-1">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_single_parent"
                                    id="registration-single-parent-1" value="0"
                                    wire:model="residentForm.is_single_parent">
                                <label class="form-check-label" for="registration-single-parent-1">
                                    No
                                </label>
                            </div>
                        </div>
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
                    <hr class="line text-brown-primary" />
                    <div class="d-flex justify-content-around">
                        <button class="btn btn-primary-brown ms-auto" type="submit">
                            Register
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-login.card-with-logo>
