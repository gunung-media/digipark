<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendation for Pension Claim</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h3,
        h4 {
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
        <h3>REKOMENDASI KLAIM JAMINAN HARI TUA</h3>
        <div class="data-tenaga-kerja">
            <h4>Data Tenaga Kerja</h4>
            <table>
                <tr>
                    <th>Nomor Induk Kependudukan</th>
                    <th>:</th>
                    <td>{{ $record->seeker->additional->identity_number }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <th>:</th>
                    <td>{{ $record->seeker->full_name }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <th>:</th>
                    <td>{{ $record->seeker->additional->birth_place }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->seeker->date_of_birth)) }}</td>
                </tr>
                <tr>
                    <th>Nomor Kartu Peserta BPJS Ketenaga Kerjaan</th>
                    <th>:</th>
                    <td>{{ $record->seeker->additional->bpjs_number }}</td>
                </tr>
                <tr>
                    <th>Kriteria Pengajuan Klaim Jaminan Hari Tua</th>
                    <th>:</th>
                    <td>{{ $record->type == 'pengunduran_diri' ? 'Pengunduran Diri' : 'Pemutusan Hubungan Kerja' }}</td>
                </tr>
            </table>
        </div>
        <div class="address">
            <p>Palangka Raya, {{ now()->format('d F Y') }}</p>
            <img src="{{ $record->signature }}" alt="Signature" class="signature">
            <p>{{ $record->seeker->full_name }}</p>
        </div>
    </div>
</body>

</html>
