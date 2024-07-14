<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Information and Records Management System</title>
    <link rel="stylesheet" href="{{url('resources/css/welcome.css')}}">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{url('resources/img/logo.png')}}" alt="">
        </div>
        <div class="button-group">
            <button onclick="location.href='{{ route('barangay_captain.login') }}'">Barangay Captain</button>
            <button onclick="location.href='{{ url('/barangay-officials') }}'">Barangay Officials</button>
            <button onclick="location.href='{{ url('/barangay-staffs') }}'">Barangay Staffs</button>
            <button onclick="location.href='{{ url('/barangay-residents') }}'">Barangay Residents</button>
        </div>
    </div>
</body>
</html>

