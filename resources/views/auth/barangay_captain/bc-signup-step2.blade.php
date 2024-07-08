<!DOCTYPE html>
<html>
<head>
    <title>Register Step 2</title>
</head>
<body>
    <form action="{{ route('register.postStep2') }}" method="POST">
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" id="middle_name">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" id="date_of_birth" required>

        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="contact_no">Contact No:</label>
        <input type="text" name="contact_no" id="contact_no" required>

        <label for="bric">BRIC#:</label>
        <input type="text" name="bric" id="bric" required>

        <button type="submit">Next</button>
    </form>
</body>
</html>
