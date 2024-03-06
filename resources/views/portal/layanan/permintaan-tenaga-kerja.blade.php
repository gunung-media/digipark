@extends('layouts.portal.app')

@section('content')
    <section class="donate-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">

                <div class="col-12 mx-auto">
                    <form class="custom-form donate-form" action="" method="post" role="form"
                        enctype="multipart/form-data">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h3 class="mb-4">Permintaan Tenaga Kerja </h3>

                        <div class="row" id="wizard">
                            <h3>IDENTITAS PEMBERI KERJA</h3>
                            <fieldset>
                                <legend>
                                    <h5>Identitas Pemberi Kerja</h5>
                                </legend>
                                <div class="form-group">
                                    <label for="">Nama Pemberi Kerja</label>
                                    <input type="text" class="form-control" name="nama_pemberi" />
                                </div>
                                <div class="form-group">
                                    <label for="">Lapangan Usaha</label>
                                    <input type="text" class="form-control" name="lapangan_usaha" />
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="">Telp kantor</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Kode Pos</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Kontak Person</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Jabatan</label>
                                    <input type="text" class="form-control">
                                </div>
                            </fieldset>

                            <h3>INFORMASI LOWONGAN JABATAN / PEKERJAAN</h3>
                            <fieldset>
                                <legend>
                                    <h5>Informasi Lowongan Jabatan/Pekerjaan</h5>
                                </legend>
                                <div class="form-group">
                                    <label for="">Nama Jabatan/Pekerjaan</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="row mt-5">
                                    <h6 for="">Jumlah Lowongan</h6>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="">Laki-Laki</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="">Perempuan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </fieldset>

                            <h3>PERSYARATAN JABATAN</h3>
                            <fieldset>
                                <legend>
                                    <h5>Persyaratan Jabatan</h5>
                                </legend>
                                <div class="row m5-5">
                                    <h6>Pendidikan Formal</h6>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="">Pendidikan Tertinggi</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 col-12 form-group">
                                        <label for="">Jurusan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Keterampilan / Kealihan</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Pengalaman</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Syarat Khusus</label>
                                    <input type="text" class="form-control">
                                </div>
                            </fieldset>

                            <h3>SISTEM PENGUPAHAN</h3>
                            <fieldset>
                                <legend>
                                    <h5>Sistem Pengupahan</h5>
                                </legend>
                                <div class="form-group">
                                    <label for="">Sistem Pengupahan</label>
                                    <select name="" id="" class="form-control">
                                        @foreach (['borongan', 'harian', 'mingguan', 'bulanan'] as $item)
                                            <option value="">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Gaji Upah Sebulan</label>
                                    <input type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Status Hubungan Kerja</label>
                                    <select name="" id="" class="form-control">
                                        @foreach (['Waktu tertentu', 'Waktu tidak tertentu'] as $item)
                                            <option value="">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah jam kerja dalam seminggu</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Jaminan Sosial Lainnya</label>
                                    <select name="" id="" multiple class="form-control">
                                        @foreach (['Waktu tertentu', 'Waktu tidak tertentu'] as $item)
                                            <option value="">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>

                            <h3>LAINNYA</h3>
                            <fieldset>
                                <legend>
                                    <h5>Lainnya</h5>
                                </legend>
                                <div class="form-group">
                                    <label for="">Uraian Singkat Pekerjaan</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Uraian Tugas</label>
                                    <input type="text" class="form-control">
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('portal/css/jquery.steps.css') }}">
@endsection

@section('script')
    <script src="{{ asset('portal/js/steps/jquery.steps.js') }}"></script>
    <script>
        const form = $("#wizard")

        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            stepsOrientation: "vertical",

            onFinished: function(event, currentIndex) {
                if (form.valid()) {
                    form.submit();
                } else {
                    alert("Form Not Valid!");
                }
            }
        })
    </script>
@endsection
