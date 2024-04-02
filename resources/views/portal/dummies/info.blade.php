@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">Informasi Ketenagakerjaan</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-12">
                        <div class="news-block">
                            <div class="news-block-info">
                                <div class="news-block-title mb-2">
                                    <h4>Jumlah Penduduk Pengangguran</h4>
                                </div>

                                <div class="news-block-body">
                                    <img src="{{ asset('dummies/1.png') }} " alt="">
                                </div>
                            </div>
                        </div>
                        <div class="news-block">
                            <div class="news-block-info">
                                <div class="news-block-title mb-2">
                                    <h4>Jumlah Penduduk Pengangguran Tingkat Kecamatan Dan Kelurahan</h4>
                                </div>

                                <div class="news-block-body">
                                    <img src="{{ asset('dummies/2.png') }} " alt="">
                                    <img src="{{ asset('dummies/3.png') }} " alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
