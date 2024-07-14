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
            <select name="region" id="region">
                <option value="">Select Region</option>
            </select>
        </div>
        <div class="form-group">
            <label for="province">Province</label>
            <select name="province" id="province" disabled>
                <option value="">Select Province</option>
            </select>
        </div>
        <div class="form-group">
            <label for="city_municipality">City / Municipality</label>
            <select name="city_municipality" id="city_municipality" disabled>
                <option value="">Select City / Municipality</option>
            </select>
        </div>
        <div class="form-group">
            <label for="barangay">Barangay</label>
            <select name="barangay" id="barangay" disabled>
                <option value="">Select Barangay</option>
            </select>
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
<script>
    $(document).ready(function() {
        // Load regions
        $.getJSON('/json/refregion.json', function(data) {
            $.each(data.RECORDS, function(key, entry) {
                $('#region').append($('<option></option>').attr('value', entry.regCode).text(entry.regDesc));
            });
        }).fail(function() {
            console.error("Failed to load regions JSON.");
        });

        // Load provinces based on selected region
        $('#region').change(function() {
            var regCode = $(this).val();
            $('#province').prop('disabled', !regCode);
            $('#province').empty().append('<option value="">Select Province</option>');

            if (regCode) {
                $.getJSON('/json/refprovince.json', function(data) {
                    $.each(data.RECORDS, function(key, entry) {
                        if (entry.regCode === regCode) {
                            $('#province').append($('<option></option>').attr('value', entry.provCode).text(entry.provDesc));
                        }
                    });
                }).fail(function() {
                    console.error("Failed to load provinces JSON.");
                });
            }

            $('#city_municipality, #barangay').prop('disabled', true).empty().append('<option value="">Select</option>');
        });

        // Load cities/municipalities based on selected province
        $('#province').change(function() {
            var provCode = $(this).val();
            $('#city_municipality').prop('disabled', !provCode);
            $('#city_municipality').empty().append('<option value="">Select City / Municipality</option>');

            if (provCode) {
                $.getJSON('/json/refcitymun.json', function(data) {
                    $.each(data.RECORDS, function(key, entry) {
                        if (entry.provCode === provCode) {
                            $('#city_municipality').append($('<option></option>').attr('value', entry.citymunCode).text(entry.citymunDesc));
                        }
                    });
                }).fail(function() {
                    console.error("Failed to load cities/municipalities JSON.");
                });
            }

            $('#barangay').prop('disabled', true).empty().append('<option value="">Select Barangay</option>');
        });

        // Load barangays based on selected city/municipality
        $('#city_municipality').change(function() {
            var citymunCode = $(this).val();
            $('#barangay').prop('disabled', !citymunCode);
            $('#barangay').empty().append('<option value="">Select Barangay</option>');

            if (citymunCode) {
                $.getJSON('/json/refbrgy.json', function(data) {
                    $.each(data.RECORDS, function(key, entry) {
                        if (entry.citymunCode === citymunCode) {
                            $('#barangay').append($('<option></option>').attr('value', entry.brgyCode).text(entry.brgyDesc));
                        }
                    });
                }).fail(function() {
                    console.error("Failed to load barangays JSON.");
                });
            }
        });
    });
</script>
@endpush
