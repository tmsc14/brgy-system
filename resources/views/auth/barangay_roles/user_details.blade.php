<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
</head>
<body>
    <h1>User Details</h1>
    <form action="{{ route('barangay_roles.userDetails') }}" method="POST">
        @csrf
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name">

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="contact_no">Contact No:</label>
        <input type="text" id="contact_no" name="contact_no" required>

        <label for="bric_no">BRIC No:</label>
        <input type="text" id="bric_no" name="bric_no" required>

        <button type="submit">Next</button>
    </form>
</body>
</html>
