<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
        }
        .barangay-info {
            line-height: 1px;
        }
        .resident-information .key {
            display: inline-block;
            width: 150px;
        }
        .resident-information .colon {
            margin-right: auto;
        }
        .barangay-captain-info {
            margin-top: 300px;
            float: left;
            text-align: center;
        }
        .barangay-captain-info span {
            text-decoration: underline;
        }
    </style>
</head>
<body>
  <div class="header">
    <div class="barangay-info">
      <p>Republic of the Philippines</p>
      <p>Province of {{$province}}</p>
      <p>Municipality of {{$city}}</p>
      <h3>BARANGAY {{$barangay}}</h3>
    </div>
      <h4>OFFICE OF THE BARANGAY CAPTAIN</h4>
      <h2>CERTIFICATE OF RESIDENCY</h2>
  </div>

  <div class="document-content">
    <p>
      <b>TO WHOM IT MAY CONCERN:</b>
    </p>
    <p>&emsp;&emsp;This is to certify that {{ $salutation }} {{ $fullName }}, whose personal data appears below, is a <b>RESIDENT</b> of this Barangay and personally known with good moral character, law-abiding citizen, and has a respectable reputation in this community.</p>

    <div class="resident-information">
      <div>
        <span class="key">Date of birth</span><span class="colon">:</span>&nbsp;{{ $dob }}
      </div>
      <div>
        <span class="key">Civil status</span><span class="colon">:</span>&nbsp;{{ $civilStatus }}
      </div>
      <div>
        <span class="key">Gender</span><span class="colon">:</span>&nbsp;{{ $gender }}
      </div>
      <div>
        <span class="key">Address/Street</span><span class="colon">:</span>&nbsp;{{ $address }}
      </div>
      <div>
        <span class="key">Purpose</span><span class="colon">:</span>&nbsp;{{ $purpose }}
      </div>
    </div> 
    
    <p>&emsp;&emsp;This certification issued upon the request of the aforementioned individual for whatever legal purpose it may serve best.</p>
    
    <p>&emsp;&emsp;Signed this {{ $dayOfCreation }} day of {{ $monthOfCreation }}, {{ $yearOfCreation }}, Barangay {{ $barangay }}, {{ $city }}, {{ $province }}, Philippines</p>
    
    <div class="barangay-captain-info">
      <span>
        {{ $barangayCaptainName }}
      </span>
        <div>Punong Barangay</div>
    </div>
  </div>
</body>
</html>