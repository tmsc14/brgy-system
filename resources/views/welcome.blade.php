<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information and Records Management System</title>
    <link rel="stylesheet" href="resources\css\welcome.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <span>B</span><span>r</span><span>g</span>y+
        </div>
        <div class="subtitle">
            Barangay Information and Records Management System
        </div>
        <div class="button-group">
            <button onclick="location.href='{{ url('/barangay-captain') }}'">Barangay Captain</button>
            <button onclick="location.href='{{ url('/barangay-officials') }}'">Barangay Officials</button>
            <button onclick="location.href='{{ url('/barangay-staffs') }}'">Barangay Staffs</button>
            <button onclick="location.href='{{ url('/barangay-residents') }}'">Barangay Residents</button>
        </div>
    </div>
</body>
</html>
