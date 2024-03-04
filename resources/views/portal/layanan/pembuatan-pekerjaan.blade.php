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
                        <h3 class="mb-4">Pembuatan Pekerjaan</h3>

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <h5 class="mb-3">Informasi Singkat</h5>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="text" name="name_job" id="donation-name" class="form-control"
                                    placeholder="Nama Pekerjaan*" required>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="text" name="address" id="donation-email" class="form-control"
                                    placeholder="Alamat*" required>
                            </div>

                            <div class="col-12 mt-2">
                                <textarea name="description" id="" cols="30" rows="10" placeholder="Deksripsi Pekerjaan*"
                                    class="form-control" required></textarea>
                            </div>

                            <div class="col-lg-12 col-12">
                                <h5 class="mt-1">Informasi Tambahan</h5>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="number" name="total_needed_man" class="form-control"
                                    placeholder="Jumlah Lelaki yang dibutuhkan">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="number" name="total_needed_woman" class="form-control"
                                    placeholder="Jumlah Wanita yang dibutuhkan">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <select name="minimal_education" id="" class="form-control">
                                    <option value="" selected disabled>Pilih Minimal Edukasi</option>
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="S1">S1</option>
                                </select>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="text" name="special" placeholder="Masukan Kebutuhan khusus"
                                    class="form-control">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="number" name="salary" placeholder="Gaji" class="form-control">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="file" name="image" placeholder="Gambar" accept="image/*"
                                    class="form-control">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <label for="">Deadline Lowongan Pekerjaan</label>
                                <input type="date" name="deadline" placeholder="Deadline Lowongan Pekerjaan"
                                    class="form-control">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <label for="">Mulai Kerja</label>
                                <input type="date" name="start_date" placeholder="Mulai Kerja" class="form-control">
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
