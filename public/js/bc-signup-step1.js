function loadProvinces(regCode, selectedProvince = '', oldCity = '', oldBarangay = '') {
    $('#province').prop('disabled', !regCode);
    $('#province').empty().append('<option value="">Select Province</option>');

    if (regCode) {
        $.getJSON('/json/refprovince.json', function (data) {
            $.each(data.RECORDS, function (key, entry) {
                if (entry.regCode === regCode) {
                    $('#province').append($('<option></option>').attr('value', entry
                        .provCode).text(entry.provDesc));
                }
            });

            if (selectedProvince) {
                $('#province').val(selectedProvince);
                loadCities(selectedProvince, oldCity, oldBarangay);
            }
        }).fail(function () {
            console.error("Failed to load provinces JSON.");
        });
    }

    $('#city_municipality, #barangay').prop('disabled', true).empty().append(
        '<option value="">Select</option>');
}

function loadCities(provCode, selectedCity = '', oldBarangay = '') {
    $('#city_municipality').prop('disabled', !provCode);
    $('#city_municipality').empty().append('<option value="">Select City / Municipality</option>');

    if (provCode) {
        $.getJSON('/json/refcitymun.json', function (data) {
            $.each(data.RECORDS, function (key, entry) {
                if (entry.provCode === provCode) {
                    $('#city_municipality').append($('<option></option>').attr('value',
                        entry.citymunCode).text(entry.citymunDesc));
                }
            });

            if (selectedCity) {
                $('#city_municipality').val(selectedCity);
                loadBarangays(selectedCity, oldBarangay);
            }
        }).fail(function () {
            console.error("Failed to load cities/municipalities JSON.");
        });
    }

    $('#barangay').prop('disabled', true).empty().append(
        '<option value="">Select Barangay</option>');
}

function loadBarangays(citymunCode, selectedBarangay = '') {
    $('#barangay').prop('disabled', !citymunCode);
    $('#barangay').empty().append('<option value="">Select Barangay</option>');

    if (citymunCode) {
        $.getJSON('/json/refbrgy.json', function (data) {
            $.each(data.RECORDS, function (key, entry) {
                if (entry.citymunCode === citymunCode) {
                    $('#barangay').append($('<option></option>').attr('value', entry
                        .brgyCode).text(entry.brgyDesc));
                }
            });

            if (selectedBarangay) {
                $('#barangay').val(selectedBarangay);
            }
        }).fail(function () {
            console.error("Failed to load barangays JSON.");
        });
    }
}
