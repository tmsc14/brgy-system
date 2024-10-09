@extends('layouts.app')

@section('content')
    <div class="signup-container">
        <div class="signup-header">
            <img src="{{ asset('resources/img/logo.png') }}" alt="Brgy+ Logo" class="logo">
            <div class="line"></div>
        </div>
        <h2>Barangay Sign Up</h2>
        <form action="{{ route('barangay_captain.register.step1.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="region">Region</label>
                <select onchange="loadProvinces(this.value)" name="region" id="region">
                    <option value="0" selected>Select Region</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region['regCode'] }}">{{ $region['regDesc'] }}</option>
                    @endforeach
                </select>
                @if ($errors->has('region'))
                    <span class="error">{{ $errors->first('region') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <select onchange="loadCities(this.value)" name="province" id="province"
                    {{ old('region') ? '' : 'disabled' }}>
                    <option value="">Select Province</option>
                </select>
                @if ($errors->has('province'))
                    <span class="error">{{ $errors->first('province') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="city_municipality">City / Municipality</label>
                <select onchange="loadBarangays(this.value)" name="city_municipality" id="city_municipality"
                    {{ old('province') ? '' : 'disabled' }}>
                    <option value="">Select City / Municipality</option>
                </select>
                @if ($errors->has('city_municipality'))
                    <span class="error">{{ $errors->first('city_municipality') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <select name="barangay" id="barangay" {{ old('city_municipality') ? '' : 'disabled' }}>
                    <option value="">Select Barangay</option>
                </select>
                @if ($errors->has('barangay'))
                    <span class="error">{{ $errors->first('barangay') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('barangay_captain.login') }}" class="login-link">Already have an account?</a>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('resources/css/bc-signup-step1.css') }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/bc-signup-step1.js') }}"></script>
    <script>
        $(document).ready(function() {
            const oldRegion = '{{ old('region') }}';
            const oldProvince = '{{ old('province') }}';
            const oldCityMunicipality = '{{ old('city_municipality') }}';
            const oldBarangay = '{{ old('barangay') }}';

            if (oldRegion) {
                $('#region').val(oldRegion);
                loadProvinces(oldRegion, oldProvince);
            }

            if (oldProvince) {
                loadCities(oldProvince, oldCityMunicipality);
            }

            if (oldCityMunicipality) {
                loadBarangays(oldCityMunicipality, oldBarangay);
            }
        });
    </script>
@endpush
