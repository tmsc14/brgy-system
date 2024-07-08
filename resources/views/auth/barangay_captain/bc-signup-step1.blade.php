<!DOCTYPE html>
<html>
<head>
    <title>Register Step 1</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form action="{{ route('register.postStep1') }}" method="POST">
        @csrf
        <label for="region">Region:</label>
        <select name="region" id="region">
            <option value="">Select Region</option>
        </select>

        <label for="province">Province:</label>
        <select name="province" id="province" disabled>
            <option value="">Select Province</option>
        </select>

        <label for="city_municipality">City / Municipality:</label>
        <select name="city_municipality" id="city_municipality" disabled>
            <option value="">Select City / Municipality</option>
        </select>

        <label for="barangay">Barangay:</label>
        <select name="barangay" id="barangay" disabled>
            <option value="">Select Barangay</option>
        </select>

        <button type="submit">Next</button>
    </form>

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
</body>
</html>
