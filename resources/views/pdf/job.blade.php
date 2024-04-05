<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN LOWONGAN</title>
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
        <h3>LAPORAN LOWONGAN</h3>
        <div class="data-tenaga-kerja">
            <!-- <h4>Data Tenaga Kerja</h4> -->
            <table>
                <tr>
                    <th>Nama Perusahaan / Pemberi Kerja</th>
                    <th>:</th>
                    <td>{{ $record->company->name }}</td>
                </tr>
                <tr>
                    <th>Pusat/Cabang/Bagian Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company->company_type }}</td>
                </tr>
                <tr>
                    <th>No. Telepon Perusahaan / Pemberi Kerja</th>
                    <th>:</th>
                    <td>{{ $record->company->phone_number }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <th>:</th>
                    <td>{{ $record->company->address }}</td>
                </tr>
                <tr>
                    <th>Nama Jabatan</th>
                    <th>:</th>
                    <td>{{ $record->name_job }}</td>
                </tr>
                <!-- <tr> -->
                <!--     <th>Deskripsi Pekerjaan</th> -->
                <!--     <th>:</th> -->
                <!--     <td>{{ $record->description }}</td> -->
                <!-- </tr> -->
                <tr>
                    <th>Jumlah Lelaki Yang Dibutuhkan</th>
                    <th>:</th>
                    <td>{{ $record->total_needed_man }}</td>
                </tr>
                <tr>
                    <th>Jumlah Wanita Yang Dibutuhkan</th>
                    <th>:</th>
                    <td>{{ $record->total_needed_woman }}</td>
                </tr>
                <tr>
                    <th>Pendidikan Terakhir</th>
                    <th>:</th>
                    <td>{{ $record->minimal_education }}</td>
                </tr>
                <tr>
                    <th>Keahlian Khusus</th>
                    <th>:</th>
                    <td>{{ $record->special }}
                    </td>
                </tr>
                <tr>
                    <th>Gaji</th>
                    <th>:</th>
                    <td>{{ $record->salary }}
                    </td>
                </tr>
                <tr>
                    <th>Deadline Lowongan Pekerjaan</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->deadline)) }}
                    </td>
                </tr>
                <tr>
                    <th>Mulai Pekerjaan</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->start_date)) }}
                    </td>
                </tr>
                <tr>
                    <th>Lokasi Pekerjaan</th>
                    <th>:</th>
                    <td>{{ $record->address }}
                    </td>
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
