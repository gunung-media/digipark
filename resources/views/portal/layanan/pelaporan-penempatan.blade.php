@extends('layouts.portal.app')

@section('content')
    <section class="donate-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mx-auto">
                    <form class="custom-form donate-form" action="{{ route('portal.layanan.pembuatanPekerjaan.store') }}"
                        method="post" role="form" enctype="multipart/form-data">
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
                        <h3 class="mb-4">Pelaporan Penempatan</h3>

                        <div class="row">
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" class="form-control" placeholder="Nama Tenaga Kerja">
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" placeholder="Jenis Kelamin" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" placeholder="Alamat Domisili" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" placeholder="Pendidikan Terakhir" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" placeholder="Jabatan Pekerjaan" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mt-2">
                                <input type="text" placeholder="Jabatan Pekerjaan" class="form-control">
                            </div>

                            <input type="hidden" name="company_id" value="{{ auth('company')->user()->id }}">

                            <div class="col-lg-12 col-12 mt-2">
                                <button type="submit" class="form-control mt-4">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
