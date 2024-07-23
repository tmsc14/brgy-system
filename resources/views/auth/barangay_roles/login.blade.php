<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="{{ route('barangay_roles.login') }}" method="POST">
        @csrf
        <label for="role">Select Role:</label>
        <select id="role" name="role" required>
            <option value="barangay_official">Barangay Official</option>
            <option value="staff">Staff</option>
            <option value="resident">Resident</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
