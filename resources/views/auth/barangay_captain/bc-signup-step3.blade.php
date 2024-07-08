<!DOCTYPE html>
<html>
<head>
    <title>Register Step 3</title>
</head>
<body>
    <form action="{{ route('register.postStep3') }}" method="POST">
        @csrf
        <label for="password">Create your own Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Retype your Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <label for="access_code">Access Code:</label>
        <input type="text" name="access_code" id="access_code" required>

        <button type="submit">Confirm</button>
    </form>
</body>
</html>
