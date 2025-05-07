<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENGESAHAN LEMBAGA LKS BIPARTIT</title>
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
        <h3>PENGESAHAN LEMBAGA LKS BIPARTIT</h3>
        <h5>{{ App\Utils\Helper::generateDocumentNumber($record->id, 'LKS-Bipartit', $record->created_at) }}</h5>
        <div class="data-tenaga-kerja">
            <table>
                <tr>
                    <th>Nama Pengurus LKS BIPARTIT</th>
                    <th>:</th>
                    <td>{{ $record->name }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <th>:</th>
                    <td>{{ $record->address }}</td>
                </tr>
                <tr>
                    <th>Nomor Telepon/WA</th>
                    <th>:</th>
                    <td>{{ $record->phone }}</td>
                </tr>
                <tr>
                    <th>Nomor Surat Keputusan Izin Usaha</th>
                    <th>:</th>
                    <td>{{ $record->permission_number }}</td>
                </tr>
                <tr>
                    <th>Tanggal Surat Keputusan Izin Usaha</th>
                    <th>:</th>
                    <td>{{ $record->permission_date }}</td>
                </tr>

                <tr>
                    <th>Nomor Kepesertaan BPJS</th>
                    <th>:</th>
                    <td>{{ $record->bpjs_number }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pengurus (Laki-Laki)</th>
                    <th>:</th>
                    <td>{{ $record->male_employee }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pengurus (Perempuan)</th>
                    <th>:</th>
                    <td>{{ $record->female_employee }}</td>
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
