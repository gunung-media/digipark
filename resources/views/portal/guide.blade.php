@php
    use Carbon\Carbon;
@endphp

@extends('layouts.portal.app')

@section('content')
    <main>
        <section class="news-detail-header-section text-center guide-section">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">Panduan</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row" style="justify-content:center  ">
                    <div class="col-12" style="margin-bottom:0rem; margin-top: -2rem;">
                        <form class="job-form custom-form" method="get">
                            <div class="row" style="width:100%; justify-content:center">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <input type="" class="form-control" name="q"
                                            value="{{ $name }}" placeholder="Nama Panduan">
                                    </div>
                                </div>
                                <div class="col-md-1 col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary custom-btn">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @forelse($datas as $data)
                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0 mt-5">
                            <a class="custom-block-wrap"
                                href="{{ $data->is_video ? $data->file : asset('storage/' . $data->file) }}"
                                target="__blank">
                                <img src="{{ asset('storage/' . $data->cover_img) }}"
                                    class="custom-block-image img-fluid guide-image" alt="Test"
                                    onerror="this.onerror=null;this.src='{{ asset('images/404.jpg') }}'">

                                <div class="custom-category-block">
                                    Panduan{{ $data->is_video ? ', Video' : '' }}
                                </div>


                                <div class="custom-block">
                                    <div class="custom-block-body">
                                        <center>
                                            <h5 class="mb-3">{{ $data->name }}</h5>
                                            <p>{{ $data->description }}</p>
                                        </center>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @empty
                        <div>
                            <center>
                                <h5>Tidak Ada Data</h5>
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

        .custom-block {
            height: auto;
        }

        .custom-block-wrap {
            cursor: pointer;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1);
        }

        .custom-block-wrap:hover {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .25);
        }

        .custom-category-block {
            background: var(--secondary-color);
            /* position: absolute; */
            border-radius: 0 0 10px 10px;
            bottom: 0;
            right: 0;
            left: 0;
            padding: 10px 20px;
            color: white;
        }

        .job-form label {
            color: white;
        }

        .guide-image {
            min-height: 450px;
        }
    </style>
@endsection
