@extends('layouts.unified_login_signup')

@section('title', 'Find Barangay')

@section('css')
<link rel="stylesheet" href="{{ asset('resources/css/unified_login_signup/find_barangay.css') }}">
@endsection

@section('content')
<div class="signup-container">
    <div class="logo">
        <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo">
    </div>
    <div class="separator"></div>
    <h1>Find Barangay</h1>
    <form id="findBarangayForm" action="{{ route('barangay_roles.findBarangay') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="region">Region:</label>
            <select id="region" name="region" required>
                <option value="">Select Region</option>
                @foreach($regions as $region)
                    <option value="{{ $region['code'] }}">{{ $region['desc'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="province">Province:</label>
            <select id="province" name="province" required disabled>
                <option value="">Select Province</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city">City/Municipality:</label>
            <select id="city" name="city" required disabled>
                <option value="">Select City/Municipality</option>
            </select>
        </div>
        <div class="form-group">
            <label for="barangay">Barangay:</label>
            <select id="barangay" name="barangay" required disabled>
                <option value="">Select Barangay</option>
            </select>
        </div>
        <button type="submit" disabled id="confirm-btn">Next</button>
    </form>
    <button onclick="window.location='{{ route('barangay_roles.selectRole') }}'" class="back-btn">Back</button>
</div>

<script>
    document.getElementById('region').addEventListener('change', function() {
        let regionCode = this.value;
        let provinceSelect = document.getElementById('province');
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        resetSelect('province');
        resetSelect('city');
        resetSelect('barangay');
        if (regionCode) {
            fetch(`/api/provinces?region=${regionCode}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(province => {
                        let option = document.createElement('option');
                        option.value = province.code;
                        option.textContent = province.desc;
                        provinceSelect.appendChild(option);
                    });
                    provinceSelect.disabled = false;
                });
        }
    });

    document.getElementById('province').addEventListener('change', function() {
        let provinceCode = this.value;
        let citySelect = document.getElementById('city');
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        resetSelect('city');
        resetSelect('barangay');
        if (provinceCode) {
            fetch(`/api/cities?province=${provinceCode}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(city => {
                        let option = document.createElement('option');
                        option.value = city.code;
                        option.textContent = city.desc;
                        citySelect.appendChild(option);
                    });
                    citySelect.disabled = false;
                });
        }
    });

    document.getElementById('city').addEventListener('change', function() {
        let cityCode = this.value;
        let barangaySelect = document.getElementById('barangay');
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        resetSelect('barangay');
        if (cityCode) {
            fetch(`/api/barangays?city=${cityCode}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(barangay => {
                        let option = document.createElement('option');
                        option.value = barangay.code;
                        option.textContent = barangay.desc;
                        barangaySelect.appendChild(option);
                    });
                    barangaySelect.disabled = false;
                });
        }
    });

    function resetSelect(selectId) {
        let selectElement = document.getElementById(selectId);
        let placeholder = {
            province: 'Select Province',
            city: 'Select City/Municipality',
            barangay: 'Select Barangay'
        };
        selectElement.innerHTML = `<option value="">${placeholder[selectId]}</option>`;
        selectElement.disabled = true;
    }

    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', validateForm);
    });

    function validateForm() {
        let region = document.getElementById('region').value;
        let province = document.getElementById('province').value;
        let city = document.getElementById('city').value;
        let barangay = document.getElementById('barangay').value;

        let confirmBtn = document.getElementById('confirm-btn');
        if (region && province && city && barangay) {
            confirmBtn.disabled = false;
        } else {
            confirmBtn.disabled = true;
        }
    }
</script>
@endsection
