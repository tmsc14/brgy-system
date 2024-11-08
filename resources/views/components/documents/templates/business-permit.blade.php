<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Indigency</title>
    <style>
        @page {
            margin: 0px;
        }

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
            margin-top: 100px;
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

        .signature {
            margin-top: 100px;
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
        <h2>BARANGAY BUSINESS PERMIT</h2>
    </div>

    <div class="document-content">
        <p style="text-indent: 0;">
            <b>TO WHOM IT MAY CONCERN:</b>
        </p>
        <p>This is to certify that {{ $previewData['name_of_owner'] }}, of legal age, a resident of
            {{ $previewData['barangayName'] }}, {{ $previewData['city'] }}, {{ $previewData['province'] }}
            is hereby granted <b>PERMIT</b> to engage in any lawful commercial operation in this jurisdiction.</p>

        <p>
            Pursuant to the provision of Section 152 of R.A. 7160 (c) and (d)
        </p>

        <p>
            The business name shall be {{ $previewData['business_name'] }} situated at
            {{ $previewData['barangayName'] }} {{ $previewData['city'] }} {{ $previewData['province'] }} of this
            locality.
        </p>

        <p>
            This <b>PERMIT</b> is issued upon request of {{ $previewData['fullName'] }} for whatever legal and lawful
            uses it may serve.
        </p>

        <p>
            Issued this {{ $previewData['dayOfCreation'] }} day of {{ $previewData['monthOfCreation'] }}
            {{ $previewData['yearOfCreation'] }} at the Office of the Punong Barangay,
            {{ $previewData['barangayName'] }},
            {{ $previewData['city'] }}, {{ $previewData['province'] }}.
        </p>
        <p style="text-indent: 0;">
            NOTE: valid until December 31, {{ $previewData['yearOfCreation'] }}.
        </p>

        <div class="resident-information">
            <div>
                <span class="key">OR No.</span><span class="colon">:</span>&nbsp;
            </div>
            <div>
                <span class="key">Issued on</span><span
                    class="colon">:</span>&nbsp;{{ $previewData['dayOfCreation'] }} day of {{ $previewData['monthOfCreation'] }} {{ $previewData['yearOfCreation'] }}
            </div>
        </div>

        <div class="signature">
            <span style="text-indent: 0;border-top:#000000 1px solid;">Name and signature of holder</span>
        </div>

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
