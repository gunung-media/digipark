<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENDAFTARAN SERIKAT PEKERJA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h3,
        h4,
        h5 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        .address {
            text-align: right;
        }

        .signature {
            width: 100px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>PENDAFTARAN SERIKAT PEKERJA</h3>
        <h5>{{ App\Utils\Helper::generateDocumentNumber($record->id, 'Bid.HIJK-01.SP', $record->created_at) }}</h5>
        <div class="data-tenaga-kerja">
            <table>
                <tr>
                    <th>Nama Pemohon</th>
                    <th>:</th>
                    <td>{{ $record->requester_name }}</td>
                </tr>
                <tr>
                    <th>Jabatan Pemohon</th>
                    <th>:</th>
                    <td>{{ $record->requester_position }}</td>
                </tr>
                <tr>
                    <th>Nama Serikat Kerja</th>
                    <th>:</th>
                    <td>{{ $record->labor_union_name }}</td>
                </tr>

                <tr>
                    <th>Alamat Serikat Kerja</th>
                    <th>:</th>
                    <td>{{ $record->labor_union_address }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon/WA</th>
                    <th>:</th>
                    <td>{{ $record->phone_number }}</td>
                </tr>
                <tr>
                    <th>Email Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company_email }}</td>
                </tr>
                <tr>
                    <th>Email Serikat Kerja</th>
                    <th>:</th>
                    <td>{{ $record->labor_union_email }}</td>
                </tr>
            </table>
        </div>
        <div class="address">
            <p>Palangka Raya, {{ now()->format('d F Y') }}</p>
            <img src="{{ $record->signature }}" alt="Signature" class="signature">
            <p>{{ $record->company->name }}</p>
        </div>
    </div>
</body>

</html>
