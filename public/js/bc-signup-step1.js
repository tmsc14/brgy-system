function loadProvinces(regCode, selectedProvince = '', oldCity = '', oldBarangay = '')
{
    $('#province').prop('disabled', !regCode);
    $('#province').empty().append('<option value="">Select Province</option>');

    if (regCode)
    {
        fetch(`/api/location/provinces/${regCode}`)
            .then(response =>
            {
                if (!response.ok)
                {
                    throw new Error('An unexpected error occured.');
                }
                return response.json();
            })
            .then(data =>
            {
                data.forEach(x =>
                {
                    $('#province').append($('<option></option>').attr('value', x.provCode).text(x.provDesc));
                })

                if (selectedProvince)
                {
                    $('#province').val(selectedProvince);
                    loadCities(selectedProvince, oldCity, oldBarangay);
                }
            })
            .catch(error =>
            {
                console.error('Error fetching user:', error);
            });
    }

    $('#city_municipality, #barangay').prop('disabled', true).empty().append(
        '<option value="">Select</option>');
}

function loadCities(provCode, selectedCity = '', oldBarangay = '')
{
    $('#city_municipality').prop('disabled', !provCode);
    $('#city_municipality').empty().append('<option value="">Select City / Municipality</option>');

    if (provCode)
    {
        fetch(`/api/location/cities/${provCode}`)
            .then(response =>
            {
                if (!response.ok)
                {
                    throw new Error('An unexpected error occured.');
                }
                return response.json();
            })
            .then(data =>
            {
                data.forEach(x =>
                {
                    $('#city_municipality').append($('<option></option>').attr('value', x.citymunCode).text(x.citymunDesc));
                })

                if (selectedCity)
                {
                    $('#city_municipality').val(selectedCity);
                    loadBarangays(selectedCity, oldBarangay);
                }
            })
            .catch(error =>
            {
                console.error(error);
            });
    }

    $('#barangay').prop('disabled', true).empty().append(
        '<option value="">Select Barangay</option>');
}

function loadBarangays(citymunCode, selectedBarangay = '')
{
    $('#barangay').prop('disabled', !citymunCode);
    $('#barangay').empty().append('<option value="">Select Barangay</option>');

    if (citymunCode)
    {
        fetch(`/api/location/barangays/${citymunCode}`)
            .then(response =>
            {
                if (!response.ok)
                {
                    throw new Error('An unexpected error occured.');
                }
                return response.json();
            })
            .then(data =>
            {
                data.forEach(x =>
                {
                    $('#barangay').append($('<option></option>').attr('value', x.brgyCode).text(x.brgyDesc));
                })

                if (selectedBarangay)
                {
                    $('#barangay').val(selectedBarangay);
                }
            })
            .catch(error =>
            {
                console.error(error);
            });
    }
}
