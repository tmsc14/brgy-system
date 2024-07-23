<!DOCTYPE html>
<html>
<head>
    <title>Find Barangay</title>
</head>
<body>
    <h1>Find Barangay</h1>
    <form action="{{ route('barangay_roles.findBarangay') }}" method="POST">
        @csrf
        <label for="region">Region:</label>
        <select id="region" name="region" required>
            <option value="">Select Region</option>
            @foreach($regions as $region)
                <option value="{{ $region }}">{{ $region }}</option>
            @endforeach
        </select>

        <label for="province">Province:</label>
        <select id="province" name="province" required disabled>
            <option value="">Select Province</option>
        </select>

        <label for="city">City/Municipality:</label>
        <select id="city" name="city" required disabled>
            <option value="">Select City/Municipality</option>
        </select>

        <label for="barangay">Barangay:</label>
        <select id="barangay" name="barangay" required disabled>
            <option value="">Select Barangay</option>
        </select>

        <button type="submit" disabled id="confirm-btn">Next</button>
    </form>

    <script>
        document.getElementById('region').addEventListener('change', function() {
            fetch(`/api/provinces?region=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    let provinceSelect = document.getElementById('province');
                    provinceSelect.innerHTML = '<option value="">Select Province</option>';
                    for (const [code, name] of Object.entries(data)) {
                        let option = document.createElement('option');
                        option.value = code;
                        option.textContent = name;
                        provinceSelect.appendChild(option);
                    }
                    provinceSelect.disabled = false;
                });
        });

        document.getElementById('province').addEventListener('change', function() {
            fetch(`/api/cities?province=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    let citySelect = document.getElementById('city');
                    citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
                    for (const [code, name] of Object.entries(data)) {
                        let option = document.createElement('option');
                        option.value = code;
                        option.textContent = name;
                        citySelect.appendChild(option);
                    }
                    citySelect.disabled = false;
                });
        });

        document.getElementById('city').addEventListener('change', function() {
            fetch(`/api/barangays?city=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    let barangaySelect = document.getElementById('barangay');
                    barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
                    for (const [code, name] of Object.entries(data)) {
                        let option = document.createElement('option');
                        option.value = code;
                        option.textContent = name;
                        barangaySelect.appendChild(option);
                    }
                    barangaySelect.disabled = false;
                });
        });

        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
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
            });
        });
    </script>
</body>
</html>
