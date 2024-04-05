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
        <h3>LAPORAN PENGESAHAN PERUSAHAAN</h3>
        <div class="data-tenaga-kerja">
            <!-- <h4>Data Tenaga Kerja</h4> -->
            <table>
                <tr>
                    <th>Nomor</th>
                    <th>:</th>
                    <td>{{ $record->id }}</td>
                </tr>
                <tr>
                    <th>Nama Perusahaan </th>
                    <th>:</th>
                    <td>{{ $record->company->name }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <th>:</th>
                    <td>{{ $record->company->address }}</td>
                </tr>
                <tr>
                    <th>No. Telepon Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company->phone_number }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <th>:</th>
                    <td>{{ $record->company->email }}</td>
                </tr>
                <tr>
                    <th>Pusat/Cabang/Bagian Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company->company_type }}</td>
                </tr>
                <tr>
                    <th>Status Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company->company_status }}</td>
                </tr>
                <tr>
                    <th>Surat Keputusan Ijin Usaha</th>
                    <th>:</th>
                    <td>{{ $record->business_license_decision_letter }}</td>
                </tr>
                <tr>
                    <th>Nama-Nama Serikat Pekerja/Serikat Buruh di perusahaan (apabila ada)</th>
                    <th>:</th>
                    <td>{{ $record->labor_union_names }}</td>
                </tr>
                <tr>
                    <th>Nomor Kepesertaan BPJS</th>
                    <th>:</th>
                    <td>{{ $record->bpjs_membership_number }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pekerja Di Pusat</th>
                    <th>:</th>
                    <td>{{ $record->headquarters_male_employee_count . ' Jumlah Laki-Laki' }}
                        {{ $record->headquarters_female_employee_count . ' Jumlah Perempuan' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pekerja di Cabang</th>
                    <th>:</th>
                    <td>{{ $record->branch_male_employee_count . ' Jumlah Laki-Laki' }}
                        {{ $record->branch_female_employee_count . ' Jumlah Perempuan' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pekerja Outsourcing</th>
                    <th>:</th>
                    <td>{{ $record->outsourced_male_employee_count . ' Jumlah Laki-Laki' }}
                        {{ $record->outsourced_female_employee_count . ' Jumlah Perempuan' }}</td>
                </tr>
                <tr>
                    <th>Konsep Peraturan Perusahaan</th>
                    <th>:</th>
                    <td>{{ $record->company_regulation_concept }}
                    </td>
                </tr>
                <tr>
                    <th>Tanggal berlakunya Peraturan Perusahaan yang baru</th>
                    <th>:</th>
                    <td>{{ date('d F Y', strtotime($record->company_regulation_effective_date)) }}
                    </td>
                </tr>
                <tr>
                    <th>Upah Pekerja Bulanan</th>
                    <th>:</th>
                    <td>{{ $record->minimum_monthly_wage . ' Minimum' }}
                        {{ $record->maximum_monthly_wage . ' Maximal' }}</td>
                </tr>
                <tr>
                    <th>Upah Pekerja Harian</th>
                    <th>:</th>
                    <td>{{ $record->minimum_daily_wage . ' Minimum' }}
                        {{ $record->maximum_daily_wage . ' Maximal' }}</td>
                </tr>
                <tr>
                    <th>Sistem Hubungan Kerja</th>
                    <th>:</th>
                    <td>{{ 'Untuk Waktu Tertentu ' . $record->permanent_employment_system . ' Orang\n' }}
                        {{ 'Untuk Waktu Tidak Tertentu ' . $record->fixed_term_employment_system . ' Orang\n' }}</td>
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
