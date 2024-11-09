<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            margin: 0px;
        }

        p {
            text-indent: 2rem;
        }

        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            width: auto;
            text-align: left;
            border: 1px solid #000;
            padding: 4px;
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
    </style>
</head>

<body>
    <div class="document-body">
        @if (isset($previewData['barangayLogo']))
            <img class="document-preview-barangay-logo" src="{{ $barangayLogo }}" />
        @endif
        <div class="document-preview-header">
            <div class="barangay-info">
                <p style="text-indent: 0;">Republic of the Philippines</p>
                <p style="text-indent: 0;">Province of {{ $province }}</p>
                <p style="text-indent: 0;">Municipality of {{ $city }}</p>
                <h3>BARANGAY {{ $barangayName }}</h3>
            </div>
            <h4>OFFICE OF THE BARANGAY CAPTAIN</h4>
            <h2>{{ strtoupper($statisticName) }} REPORT</h2>
        </div>

        <div class="document-content">
            <table>
                <thead>
                    <tr>
                        @foreach ($tableStructure as $header => $callback)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            @foreach ($tableStructure as $callback)
                                <td>{{ $callback($record) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
