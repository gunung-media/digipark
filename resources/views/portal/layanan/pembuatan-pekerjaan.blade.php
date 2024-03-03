@extends('layouts.portal.app')

@section('content')
    <section class="donate-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mx-auto">
                    <form class="custom-form donate-form" action="#" method="get" role="form">
                        <h3 class="mb-4">Pembuatan Pekerjaan</h3>

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <h5 class="mb-3">Informasi Singkat</h5>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="text" name="donation-name" id="donation-name" class="form-control"
                                    placeholder="Nama Pekerjaan" required>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="text" name="donation-email" id="donation-email" class="form-control"
                                    placeholder="Alamat" required>
                            </div>

                            <div class="col-lg-12 col-12">
                                <h5 class="mt-1">Informasi Tambahan</h5>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="number" name="total_needed_man" class="form-control"
                                    placeholder="Jumlah Lelaki yang dibutuhkan">
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="number" name="donation-email" class="form-control"
                                    placeholder="Jumlah Wanita yang dibutuhkan">
                            </div>

                            <div class="col-lg-12 col-12 mt-2">
                                <button type="submit" class="form-control mt-4">Submit Donation</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
