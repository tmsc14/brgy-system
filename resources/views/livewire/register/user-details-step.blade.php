<form wire:submit="register">
    <div class="d-flex flex-column align-items-center w-100">
        <h2 class="text-brown-secondary py-4">Register Barangay</h2>
        @csrf
        <div class="d-flex flex-column gap-3 w-100 bg-brown-secondary p-4 rounded">
            <div class="d-flex gap-4 mb-4 flex-column flex-xl-row">
                @foreach ($steps as $step)
                    <div>
                        @if ($step->isCurrent())
                            <span class="fs-4 text text-primary fw-bold">
                                {{ $step->order }}. {{ $step->label }}
                            </span>
                        @else
                            <span class="fs-4 text text-brown-primary">
                                {{ $step->order }}. {{ $step->label }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
            <h3 class="text-brown-primary fw-bold">Barangay Captain Details</h3>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationFirstName" wire:model="firstName" propertyName="firstName"
                    label="First Name" type="text" placeholder="Enter your first name here." />
                <x-form-text-input id="registrationMiddleName" wire:model="middleName" propertyName="middleName"
                    label="Middle Name" type="text" placeholder="Enter your middle name here." />
                <x-form-text-input id="registrationLastName" wire:model="lastName" propertyName="lastName"
                    label="Last Name" type="text" placeholder="Enter your last name here." />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-select id="registrationGender" label="Gender" wire:model="gender" propertyName="gender"
                    class="flex-grow-1">
                    <option value="Male" {{ old('gender', session('gender')) == 'Male' ? 'selected' : '' }}>Male
                    </option>
                    <option value="Female" {{ old('gender', session('gender')) == 'Female' ? 'selected' : '' }}>Female
                    </option>
                    <option value="Other" {{ old('gender', session('gender')) == 'Other' ? 'selected' : '' }}>Other
                    </option>
                </x-form-select>
                <x-form-text-input id="registrationDateOfBirth" wire:model="dateOfBirth" propertyName="dateOfBirth"
                    label="Date of Birth" type="date" placeholder="Date of birth" class="flex-grow-1" />
            </div>
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <x-form-text-input id="registrationContactNumber" label="Contact Number" wire:model="contactNumber"
                    propertyName="contactNumber" type="text" placeholder="Contact Number" class="flex-grow-1" />
                <x-form-text-input id="registrationBricNumber" wire:model="bricNumber" propertyName="bricNumber"
                    label="BRIC Number" type="text" placeholder="BRIC Number" class="flex-grow-1" />
            </div>
            <x-form-text-input id="registrationEmail" label="Email" wire:model="email" propertyName="email"
                type="text" />
            <x-form-password id="registerPassword" label="Password" propertyName="password" 
                wire:model="password" />
            <x-form-password id="confirmPassword" label="Confirm Password" propertyName="confirmPassword" 
                wire:model="confirmPassword" />
            <div class="d-flex flex-column justify-content-center gap-3 flex-xl-row">
                <div class="form-group flex-grow-1">
                    <label for="registrationValidId" class="text-brown-primary">Valid I.D.</label>
                    <input class="form-control" type="file" id="registrationValidId" wire:model="validId">
                    @error('validId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <x-form-text-input id="registrationAccessCode" wire:model="accessCode" propertyName="accessCode"
                    label="Access Code" type="password" class="flex-grow-1" />
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
