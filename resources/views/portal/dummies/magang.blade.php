@extends('layouts.portal.app')

@section('content')
    <main>
        <section class="news-detail-header-section text-center">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">List Pelatihan dan Magang</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12" style="margin-bottom:0rem; margin-top: -2rem;">
                        <form class="job-form custom-form" method="get">
                            <div class="col-lg-5 col-12">
                                <div class="form-group">
                                    <input type="" class="form-control" name="q" value=""
                                        placeholder="Nama Pelatihan/Magang">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary custom-btn">Cari</button>
                            </div>
                        </form>
                    </div>

                    @forelse([1,2,3,4] as $job)
                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0 mt-5">
                            <div class="custom-block-wrap">
                                <img src="{{ asset('test') }}" class="custom-block-image img-fluid job-image" alt="Test"
                                    onerror="this.onerror=null;this.src='{{ asset('images/404.jpg') }}'">
                                <div class="custom-block">
                                    <div class="custom-block-body">
                                        <h5 class="mb-3">Latihan Pemrograman</h5>
                                        <p>1 Maret 2024 - 11 Maret 2024</p>
                                    </div>

                                    <a href="#" class="custom-btn btn">Detail</a>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div>
                            <center>
                                <h5>No Data Available </h5>
                            </center>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>
@endsection

@section('css')
    <style>
        .job-form {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 2rem;

        }

        .job-form label {
            color: white;
        }
    </style>
@endsection
