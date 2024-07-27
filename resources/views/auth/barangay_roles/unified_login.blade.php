<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="{{ route('barangay_roles.unifiedLogin') }}" method="POST">
        @csrf
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="barangay_official">Barangay Official</option>
                <option value="barangay_staff">Staff</option>
                <option value="barangay_resident">Resident</option>
            </select>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
