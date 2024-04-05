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
        <h3>LAPORAN PHK</h3>
        <div class="data-tenaga-kerja">
            <!-- <h4>Data Tenaga Kerja</h4> -->
            <table>
                <tr>
                    <th>Nomor</th>
                    <th>:</th>
                    <td>{{ $record->id }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <th>:</th>
                    <td>{{ $record->responsible_name }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <th>:</th>
                    <td>{{ $record->responsible_position }}</td>
                </tr>
                <tr>
                    <th>Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company->name }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <th>:</th>
                    <td>{{ $record->company->name }}</td>
                </tr>
                <tr>
                    <th>Berdasarkan surat perusahaan nomor</th>
                    <th>:</th>
                    <td>{{ $record->total_needed_man ?? 0 }}</td>
                </tr>
                <tr>
                    <th>yang menandatangani oleh saudara / saudari</th>
                    <th>:</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Surat tanggapan pekerja/buruh tanggal</th>
                    <th>:</th>
                    <td>{{ $record->name }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <th>:</th>
                    <td>{{ $record->position }}
                    </td>
                </tr>
                <tr>
                    <th>Unit kerja / Divisi</th>
                    <th>:</th>
                    <td>{{ $record->division }}
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Perjanjian Kerja</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->start_contract)) }}</td>
                </tr>
                <tr>
                    <th>Dengan ini kami laporkan bahwa :</th>
                    <th>:</th>
                    <td></td>
                </tr>
                <tr>
                    <th>1. Alasan pemutusan hubungan kerja</th>
                    <th>:</th>
                    <td>{!! $record->reason !!}
                    </td>
                </tr>
                <tr>
                    <th>2. Kompensasi pemutusan hubungan kerja dan hak-hak lainnya dibayar pada tanggal</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->end_contract)) }}</td>
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
