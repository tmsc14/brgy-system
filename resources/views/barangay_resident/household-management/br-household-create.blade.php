@extends('layouts.role_dashboard')

@section('styles')
    @vite(['resources/css/barangay_resident/household-management/br-household-create.css'])
@endsection

@section('content')
<div class="household-management-container">
    <h2>Housing and Resident Details</h2>
    
    <form action="{{ route('households.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="num_residents">No. of Residents in Household</label>
            <input type="number" id="num_residents" name="num_residents" min="1" max="20" value="1" required>
            @error('num_residents')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
        
        <div id="residents-container">
            <!-- JavaScript will dynamically generate these fields based on the selected number -->
            <div class="resident-fields" data-index="1">
                <h3>Resident 1</h3>
                <div class="form-group-inline">
                    <div class="form-group">
                        <label for="first_name_1">First Name</label>
                        <input type="text" id="first_name_1" name="residents[1][first_name]" required>
                        @error('residents.1.first_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="middle_name_1">Middle Name</label>
                        <input type="text" id="middle_name_1" name="residents[1][middle_name]">
                        @error('residents.1.middle_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name_1">Last Name</label>
                        <input type="text" id="last_name_1" name="residents[1][last_name]" required>
                        @error('residents.1.last_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group-inline">
                    <div class="form-group">
                        <label for="dob_1">Date of Birth</label>
                        <input type="date" id="dob_1" name="residents[1][dob]" required>
                        @error('residents.1.dob')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bric_no_1">BRIC #</label>
                        <input type="text" id="bric_no_1" name="residents[1][bric_no]" required>
                        @error('residents.1.bric_no')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender_1">Gender</label>
                        <select id="gender_1" name="residents[1][gender]" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('residents.1.gender')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="is_employee_1" name="residents[1][is_employee]" value="1">
                        Is the resident a Barangay Official, Staff, or Employee?
                    </label>
                    @error('residents.1.is_employee')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary">Confirm</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('num_residents').addEventListener('input', function() {
        let numResidents = parseInt(this.value);
        let container = document.getElementById('residents-container');

        container.innerHTML = ''; // Clear previous fields

        for (let i = 1; i <= numResidents; i++) {
            let residentFields = `
                <div class="resident-fields" data-index="${i}">
                    <h3>Resident ${i}</h3>
                    <div class="form-group-inline">
                        <div class="form-group">
                            <label for="first_name_${i}">First Name</label>
                            <input type="text" id="first_name_${i}" name="residents[${i}][first_name]" required>
                            @error('residents.${i}.first_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="middle_name_${i}">Middle Name</label>
                            <input type="text" id="middle_name_${i}" name="residents[${i}][middle_name]">
                            @error('residents.${i}.middle_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name_${i}">Last Name</label>
                            <input type="text" id="last_name_${i}" name="residents[${i}][last_name]" required>
                            @error('residents.${i}.last_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group-inline">
                        <div class="form-group">
                            <label for="dob_${i}">Date of Birth</label>
                            <input type="date" id="dob_${i}" name="residents[${i}][dob]" required>
                            @error('residents.${i}.dob')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bric_no_${i}">BRIC #</label>
                            <input type="text" id="bric_no_${i}" name="residents[${i}][bric_no]" required>
                            @error('residents.${i}.bric_no')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gender_${i}">Gender</label>
                            <select id="gender_${i}" name="residents[${i}][gender]" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('residents.${i}.gender')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="is_employee_${i}" name="residents[${i}][is_employee]" value="1">
                            Is the resident a Barangay Official, Staff, or Employee?
                        </label>
                        @error('residents.${i}.is_employee')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', residentFields);
        }
    });
</script>
@endsection
