<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN PERUSAHAAN</title>
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
    <div class="address">
        <p>Palangka Raya, {{ now()->format('d F Y') }}</p>
        <img src="{{ $record->signature }}" alt="Signature" class="signature">
        <p>{{ $record->name }}</p>
        <table class="data-tenaga-kerja">
            <tr>
                <th>Nama Perusahaan </th>
                <th>:</th>
                <td>{{ $record->name }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <th>:</th>
                <td>{{ $record->address }}</td>
            </tr>
            <tr>
                <th>No. Telepon Perusahaan</th>
                <th>:</th>
                <td>{{ $record->phone_number }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <th>:</th>
                <td>{{ $record->email }}</td>
            </tr>
            <tr>
                <th>Pusat/Cabang/Bagian Perusahaan</th>
                <th>:</th>
                <td>{{ $record->company_type }}</td>
            </tr>
            <tr>
                <th>Status Perusahaan</th>
                <th>:</th>
                <td>{{ $record->company_status }}</td>
            </tr>
        </table>

    </div>

    <div class="container">
        <h3>LAPORAN PHK</h3>
        <div class="data-tenaga-kerja">
            <table>
                @foreach ($record->laid_offs ?? [] as $laidOffs)
                    <tr>
                        <th>Nomor</th>
                        <th>:</th>
                        <td>{{ $laidOffs->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <th>:</th>
                        <td>{{ $laidOffs->responsible_name }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <th>:</th>
                        <td>{{ $laidOffs->responsible_position }}</td>
                    </tr>
                    <tr>
                        <th>Berdasarkan surat perusahaan nomor</th>
                        <th>:</th>
                        <td>{{ $laidOffs->total_needed_man ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>yang menandatangani oleh saudara / saudari</th>
                        <th>:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Surat tanggapan pekerja/buruh tanggal</th>
                        <th>:</th>
                        <td>{{ $laidOffs->name }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <th>:</th>
                        <td>{{ $laidOffs->position }}
                        </td>
                    </tr>
                    <tr>
                        <th>Unit kerja / Divisi</th>
                        <th>:</th>
                        <td>{{ $laidOffs->division }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Perjanjian Kerja</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($laidOffs->start_contract)) }}</td>
                    </tr>
                    <tr>
                        <th>Dengan ini kami laporkan bahwa :</th>
                        <th>:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>1. Alasan pemutusan hubungan kerja</th>
                        <th>:</th>
                        <td>{!! $laidOffs->reason !!}
                        </td>
                    </tr>
                    <tr>
                        <th>2. Kompensasi pemutusan hubungan kerja dan hak-hak lainnya dibayar pada tanggal</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($laidOffs->end_contract)) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="container">
        <h3>LAPORAN PENGESAHAN PERUSAHAAN</h3>
        <div class="data-tenaga-kerja">
            <table>
                @foreach ($record->legalization ?? [] as $legalization)
                    <tr>
                        <th>Nomor</th>
                        <th>:</th>
                        <td>{{ $legalization->id }}</td>
                    </tr>
                    <tr>
                        <th>Surat Keputusan Ijin Usaha</th>
                        <th>:</th>
                        <td>{{ $legalization->business_license_decision_letter }}</td>
                    </tr>
                    <tr>
                        <th>Nama-Nama Serikat Pekerja/Serikat Buruh di perusahaan (apabila ada)</th>
                        <th>:</th>
                        <td>{{ $legalization->labor_union_names }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Kepesertaan BPJS</th>
                        <th>:</th>
                        <td>{{ $legalization->bpjs_membership_number }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pekerja Di Pusat</th>
                        <th>:</th>
                        <td>
                            {{ $legalization->headquarters_male_employee_count }} Jumlah Laki-Laki<br>
                            {{ $legalization->headquarters_female_employee_count }} Jumlah Perempuan
                        </td>
                    </tr>
                    <tr>
                        <th>Jumlah Pekerja di Cabang</th>
                        <th>:</th>
                        <td>
                            {{ $legalization->branch_male_employee_count }} Jumlah Laki-Laki<br>
                            {{ $legalization->branch_female_employee_count }} Jumlah Perempuan
                        </td>
                    </tr>
                    <tr>
                        <th>Jumlah Pekerja Outsourcing</th>
                        <th>:</th>
                        <td>
                            {{ $legalization->outsourced_male_employee_count }} Jumlah Laki-Laki<br>
                            {{ $legalization->outsourced_female_employee_count }} Jumlah Perempuan
                        </td>
                    </tr>
                    <tr>
                        <th>Konsep Peraturan Perusahaan</th>
                        <th>:</th>
                        <td>{{ $legalization->company_regulation_concept }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal berlakunya Peraturan Perusahaan yang baru</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($legalization->company_regulation_effective_date)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Upah Pekerja Bulanan</th>
                        <th>:</th>
                        <td>
                            {{ $legalization->minimum_monthly_wage }} Minimum<br>
                            {{ $legalization->maximum_monthly_wage }} Maksimal
                        </td>
                    </tr>
                    <tr>
                        <th>Upah Pekerja Harian</th>
                        <th>:</th>
                        <td>
                            {{ $legalization->minimum_daily_wage }} Minimum<br>
                            {{ $legalization->maximum_daily_wage }} Maksimal
                        </td>
                    </tr>
                    <tr>
                        <th>Sistem Hubungan Kerja</th>
                        <th>:</th>
                        <td>
                            Untuk Waktu Tertentu {{ $legalization->permanent_employment_system }} Orang<br>
                            Untuk Waktu Tidak Tertentu {{ $legalization->fixed_term_employment_system }} Orang
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="container">
        <h3>LAPORAN LOWONGAN</h3>
        <div class="data-tenaga-kerja">
            <table>
                @foreach ($record->jobs ?? [] as $job)
                    <tr>
                        <th>Nama Jabatan</th>
                        <th>:</th>
                        <td>{{ $job->name_job }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Lelaki Yang Dibutuhkan</th>
                        <th>:</th>
                        <td>{{ $job->total_needed_man }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Wanita Yang Dibutuhkan</th>
                        <th>:</th>
                        <td>{{ $job->total_needed_woman }}</td>
                    </tr>
                    <tr>
                        <th>Pendidikan Terakhir</th>
                        <th>:</th>
                        <td>{{ $job->minimal_education }}</td>
                    </tr>
                    <tr>
                        <th>Keahlian Khusus</th>
                        <th>:</th>
                        <td>{{ $job->special }}
                        </td>
                    </tr>
                    <tr>
                        <th>Gaji</th>
                        <th>:</th>
                        <td>{{ $job->salary }}
                        </td>
                    </tr>
                    <tr>
                        <th>Deadline Lowongan Pekerjaan</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($job->deadline)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Mulai Pekerjaan</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($job->start_date)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Lokasi Pekerjaan</th>
                        <th>:</th>
                        <td>{{ $job->address }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="container">
        <h3>LAPORAN PERMINTAAN TENAGA KERJA</h3>
        <div class="data-tenaga-kerja">
            <table>
                @foreach ($record->labor_demands ?? [] as $laborDemand)
                    <tr>

                        <th>Batas Waktu Permintaan</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($laborDemand->request_deadline)) }}</td>
                    </tr>
                    <tr>
                        <th>INFORMASI LOWONGAN JABATAN / PEKERJAAN</th>
                        <th>:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Nama Jabatan / Pekerjaan</th>
                        <th>:</th>
                        <td>{{ $laborDemand->name_job }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Lelaki Yang Dibutuhkan</th>
                        <th>:</th>
                        <td>{{ $laborDemand->total_man_needs }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Wanita Yang Dibutuhkan</th>
                        <th>:</th>
                        <td>{{ $laborDemand->total_woman_needs }}</td>
                    </tr>
                    <tr>
                        <th>PERSYARATAN JABATAN</th>
                        <th>:</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Pendidikan Tertinggi</th>
                        <th>:</th>
                        <td>{{ $laborDemand->education }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <th>:</th>
                        <td>{{ $laborDemand->major }}</td>
                    </tr>
                    <tr>
                        <th>Keahlian Khusus</th>
                        <th>:</th>
                        <td>{!! $laborDemand->skills !!}
                        </td>
                    </tr>
                    <tr>
                        <th>PENGALAMAN</th>
                        <th>:</th>
                        <td>{!! $laborDemand->experience !!}
                        </td>
                    </tr>
                    <tr>
                        <th>SYARAT KHUSUS</th>
                        <th>:</th>
                        <td>{!! $laborDemand->special_conditions !!}
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
                        <td>{{ $laborDemand->wage_system }}</td>
                    </tr>
                    <tr>
                        <th>Gaji / Upah Sebulan</th>
                        <th>:</th>
                        <td>{{ $laborDemand->salary }}</td>
                    </tr>
                    <tr>
                        <th>Status Hubungan Kerja</th>
                        <th>:</th>
                        <td>{{ $laborDemand->work_status }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah jam kerja dalam seminggu</th>
                        <th>:</th>
                        <td>{{ $laborDemand->total_hours_per_week }}</td>
                    </tr>
                    <tr>
                        <th>Jaminan Sosial Lainnya</th>
                        <th>:</th>
                        <td>{{ collect($laborDemand->social_guarantee)->implode(', ') }}</td>
                    </tr>
                    <tr>
                        <th>Uraian Singkat Pekerjaan</th>
                        <th>:</th>
                        <td>{!! $laborDemand->work_description !!}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="container">
        <h3>LAPORAN PENEMPATAN</h3>
        <div class="data-tenaga-kerja">
            <table>
                @foreach ($record->placements ?? [] as $placement)
                    <tr>
                        <th>Nama Tenaga Kerja</th>
                        <th>:</th>
                        <td>{{ $placement->name }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <th>:</th>
                        <td>{{ $placement->identity_number }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <th>:</th>
                        <td>{{ $placement->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Domisili</th>
                        <th>:</th>
                        <td>{{ $placement->address }}</td>
                    </tr>
                    <tr>
                        <th>Pendidikan Terakhir</th>
                        <th>:</th>
                        <td>{{ $placement->education }}
                        </td>
                    </tr>
                    <tr>
                        <th>Nomor Kontrak</th>
                        <th>:</th>
                        <td>{{ $placement->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai Bekerja</th>
                        <th>:</th>
                        <td>{{ date('d F Y', strtotime($placement->date_worked)) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <th>:</th>
                        <td>{{ $placement->position }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <th>:</th>
                        <td>{!! $placement->description !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
