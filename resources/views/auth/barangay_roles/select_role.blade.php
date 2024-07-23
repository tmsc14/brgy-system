<!DOCTYPE html>
<html>
<head>
    <title>Select Role</title>
</head>
<body>
    <h1>Select Your Role</h1>
    <form action="{{ route('barangay_roles.selectRole') }}" method="POST">
        @csrf
        <label for="role">Select Role:</label>
        <select id="role" name="role" required>
            <option value="barangay_official">Barangay Official</option>
            <option value="barangay_staff">Staff</option>
            <option value="barangay_resident">Resident</option>
        </select>
        <button type="submit">Next</button>
    </form>
</body>
</html>
