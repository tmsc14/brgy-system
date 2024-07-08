<!DOCTYPE html>
<html>
<head>
    <title>Register Step 1</title>
</head>
<body>
    <form action="{{ route('register.postStep1') }}" method="POST">
        @csrf
        <label for="region">Region:</label>
        <select name="region" id="region">
            <!-- Options for regions -->
        </select>
        <label for="province">Province:</label>
        <select name="province" id="province">
            <!-- Options for provinces -->
        </select>
        <label for="city_municipality">City / Municipality:</label>
        <select name="city_municipality" id="city_municipality">
            <!-- Options for cities/municipalities -->
        </select>
        <label for="barangay">Barangay:</label>
        <select name="barangay" id="barangay">
            <!-- Options for barangays -->
        </select>
        <button type="submit">Next</button>
    </form>
</body>
</html>
