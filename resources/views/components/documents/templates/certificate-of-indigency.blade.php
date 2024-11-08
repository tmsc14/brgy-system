<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Indigency</title>
    <style>
        @page { margin: 0px; }

        p {
            text-indent: 2rem;
        }

        .document-body {
            font-size: 12px;
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 1in;
            background-color: #ffffff;
            max-width: 595.28px;
            max-height: 841.89px;
            box-sizing: content-box;
            line-height: normal;
            position: relative;
            color: black;
        }

        .document-preview-header {
            text-align: center;
            position: relative;
        }

        .barangay-info {
            line-height: 1px;
        }

        h4 {
            line-height: revert;
            margin-bottom: revert;
            margin-top: revert;
            font-weight: revert;
        }

        h3 {
            line-height: revert;
            margin-bottom: revert;
            margin-top: revert;
            font-weight: revert;
        }

        h2 {
            line-height: revert;
            margin-bottom: revert;
            margin-top: revert;
            font-weight: revert;
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
            width: 30%;
        }

        .barangay-captain-info span {
            text-decoration: underline;
        }

        .barangay-captain-info-inner {
            text-align: center;
        }

        .document-preview-barangay-logo {
            width: 100px;
            height: 100px;
            position: absolute;
            top: 15%;
            left: 15%;
            transform: translateY(-50%);
        }

        .approved-by {
            margin-bottom: 100px;
        }
    </style>
</head>
<div class="document-body">
    @if (isset($previewData['barangayLogo']))
        <img class="document-preview-barangay-logo" src="{{ $previewData['barangayLogo'] }}" />
    @endif
    <div class="document-preview-header">
        <div class="barangay-info">
            <p style="text-indent: 0;">Republic of the Philippines</p>
            <p style="text-indent: 0;">Province of {{ $previewData['province'] }}</p>
            <p style="text-indent: 0;">Municipality of {{ $previewData['city'] }}</p>
            <h3>BARANGAY {{ $previewData['barangayName'] }}</h3>
        </div>
        <h4>OFFICE OF THE BARANGAY CAPTAIN</h4>
        <h2>CERTIFICATE OF INDIGENCY</h2>
    </div>

    <div class="document-content">
        <p style="text-indent: 0;">
            <b>TO WHOM IT MAY CONCERN:</b>
        </p>
        <p>This is to certify that {{ $previewData['fullName'] }}, whose
            personal data appears below, is  personally known to the undersigned is a resident of 
            Barangay {{ $previewData['barangayName'] }}, {{ $previewData['city'] }}, {{ $previewData['province'] }} with good moral character, law-abiding citizen
            in the community and belongs to the <b>INDIGENT FAMILY</b> in our barangay and he/she has visibly no money, property or means of livelihood sufficient
            and available for daily food, shelter, and basic necessities for him/herself and his/her family.</p>

        <div class="resident-information">
            <div>
                <span class="key">Date of birth</span><span class="colon">:</span>&nbsp;{{ $previewData['dob'] }}
            </div>
            <div>
                <span class="key">Gender</span><span class="colon">:</span>&nbsp;{{ $previewData['gender'] }}
            </div>
            <div>
                <span class="key">Name of Guardian/Caregiver</span><span
                    class="colon">:</span>&nbsp;{{ $previewData['guardian_name'] }}
            </div>
            <div>
                <span class="key">Relationship</span><span
                    class="colon">:</span>&nbsp;{{ $previewData['relationship_to_guardian'] }}
            </div>
            <div>
                <span class="key">Purpose</span><span class="colon">:</span>&nbsp;{{ $previewData['purpose'] }}
            </div>
        </div>

        <p>This certification is being issued upon the verbal request of the above-named person for whatever legal and lawful purposes it may serve best.</p>

        <p>Signed this {{ $previewData['dayOfCreation'] }} day of {{ $previewData['monthOfCreation'] }},
            {{ $previewData['yearOfCreation'] }}, Barangay {{ $previewData['barangayName'] }},
            {{ $previewData['city'] }}, {{ $previewData['province'] }}, Philippines</p>

        <div class="barangay-captain-info">
            <div class="approved-by">Approved by:</div>
            <div class="barangay-captain-info-inner">
                <span>
                    <b>{{ $previewData['barangayCaptainName'] }}</b>
                </span>
                <div>Punong Barangay</div>
            </div>
        </div>
    </div>
</div>

</html>
