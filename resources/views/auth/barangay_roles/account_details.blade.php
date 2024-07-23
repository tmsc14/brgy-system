<!DOCTYPE html>
<html>
<head>
    <title>Account Details</title>
</head>
<body>
    <h1>Account Details</h1>
    <form action="{{ route('barangay_roles.accountDetails') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="password">Create Your Own Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Re-type Your Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <label for="valid_id">Valid ID:</label>
        <input type="file" id="valid_id" name="valid_id" required>

        @if(session('role') == 'barangay_official')
            <label for="position">Position:</label>
            <input type="text" id="position" name="position" required>
        @elseif(session('role') == 'barangay_staff')
            <label for="role">Role:</label>
            <input type="text" id="role" name="role" required>
        @endif

        <button type="submit">Complete Registration</button>
    </form>
</body>
</html>
