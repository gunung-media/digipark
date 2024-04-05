<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PERMINTAAN TENAGA KERJA</title>
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
        <h3>LAPORAN PERMINTAAN TENAGA KERJA</h3>
        <div class="data-tenaga-kerja">
            <!-- <h4>Data Tenaga Kerja</h4> -->
            <table>
                <tr>
                    <th>Batas Waktu Permintaan</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->request_deadline)) }}</td>
                </tr>
                <tr>
                    <th>INFORMASI LOWONGAN JABATAN / PEKERJAAN</th>
                    <th>:</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Nama Jabatan / Pekerjaan</th>
                    <th>:</th>
                    <td>{{ $record->name_job }}</td>
                </tr>
                <tr>
                    <th>Jumlah Lelaki Yang Dibutuhkan</th>
                    <th>:</th>
                    <td>{{ $record->total_man_needs }}</td>
                </tr>
                <tr>
                    <th>Jumlah Wanita Yang Dibutuhkan</th>
                    <th>:</th>
                    <td>{{ $record->total_woman_needs }}</td>
                </tr>
                <tr>
                    <th>PERSYARATAN JABATAN</th>
                    <th>:</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Pendidikan Tertinggi</th>
                    <th>:</th>
                    <td>{{ $record->education }}</td>
                </tr>
                <tr>
                    <th>Jurusan</th>
                    <th>:</th>
                    <td>{{ $record->major }}</td>
                </tr>
                <tr>
                    <th>Keahlian Khusus</th>
                    <th>:</th>
                    <td>{!! $record->skills !!}
                    </td>
                </tr>
                <tr>
                    <th>PENGALAMAN</th>
                    <th>:</th>
                    <td>{!! $record->experience !!}
                    </td>
                </tr>
                <tr>
                    <th>SYARAT KHUSUS</th>
                    <th>:</th>
                    <td>{!! $record->special_conditions !!}
                    </td>
                </tr>
                <tr>
                    <th>SISTEM PENGUPAHAN</th>
                    <th>:</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Sistem Pengupahan</th>
                    <th>:</th>
                    <td>{{ $record->wage_system }}</td>
                </tr>
                <tr>
                    <th>Gaji / Upah Sebulan</th>
                    <th>:</th>
                    <td>{{ $record->salary }}</td>
                </tr>
                <tr>
                    <th>Status Hubungan Kerja</th>
                    <th>:</th>
                    <td>{{ $record->work_status }}</td>
                </tr>
                <tr>
                    <th>Jumlah jam kerja dalam seminggu</th>
                    <th>:</th>
                    <td>{{ $record->total_hours_per_week }}</td>
                </tr>
                <tr>
                    <th>Jaminan Sosial Lainnya</th>
                    <th>:</th>
                    <td>{{ collect($record->social_guarantee)->implode(', ') }}</td>
                </tr>
                <tr>
                    <th>Uraian Singkat Pekerjaan</th>
                    <th>:</th>
                    <td>{!! $record->work_description !!}</td>
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
