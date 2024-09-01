<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Already Exists</title>
    @vite(['resources/css/barangay_captain/pending-turnover.css'])
</head>
<body>
    <div class="placeholder-container">
        <h1>Barangay Already Exists</h1>
        <p>This barangay has already been created by another Barangay Captain.</p>
    
        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>   
</body>
</html>
