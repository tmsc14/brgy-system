<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Residency</title>
    <style>
        .document-body {
            font-size: 12px;
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 1in;
            background-color: #f9f9f9;
            max-width: 595.28px;
            max-height: 841.89px;
        }

        .document-preview-header {
            text-align: center;
        }

        .barangay-info {
            line-height: 1px;
        }

        .resident-information .key {
            display: inline-block;
            width: 120px;
        }

        .resident-information .colon {
            margin-right: auto;
        }

        .barangay-captain-info {
            margin-top: 300px;
            margin-right: auto;
            width:30%;
        }

        .barangay-captain-info span {
            text-decoration: underline;
        }

        .barangay-captain-info-inner {
            text-align: center;
        }
    </style>
</head>
<div class="document-body">
    <div class="document-preview-header">
        <div class="barangay-info">
            <p>Republic of the Philippines</p>
            <p>Province of {{$province}}</p>
            <p>Municipality of {{$city}}</p>
            <h3>BARANGAY {{$barangayName}}</h3>
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

        <p>&emsp;&emsp;Signed this {{ $dayOfCreation }} day of {{ $monthOfCreation }}, {{ $yearOfCreation }}, Barangay {{ $barangayName }}, {{ $city }}, {{ $province }}, Philippines</p>

        <div class="barangay-captain-info">
            <div class="barangay-captain-info-inner">
                <span>
                    <b>{{ $barangayCaptainName }}</b>
                </span>
                <div>Punong Barangay</div>
            </div>
        </div>
    </div>
</div>

</html>