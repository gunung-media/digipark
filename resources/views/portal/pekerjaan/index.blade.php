@extends('layouts.portal.app')

@section('content')
    <main>
        <section class="news-detail-header-section text-center">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">List Pekerjaan</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12" style="margin-bottom:4rem; margin-top: -2rem;">
                        <form class="job-form" method="get">
                            <div class="col-lg-5 col-12">
                                <center>
                                    <h5 for="">Nama Pekerjaan</h5>
                                </center>
                                <div class="form-group">
                                    <input type="" class="form-control" name="q" value="{{ $name }}">
                                </div>
                            </div>
                            <button class="btn btn-primary">Seek</button>
                        </form>
                    </div>

                    @forelse($jobs as $job)
                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                            <div class="custom-block-wrap">
                                <img src="{{ asset(is_null($job->image) ? 'storage/' . $job->company->image : 'storage/' . $job->image) }}"
                                    class="custom-block-image img-fluid job-image" alt="{{ $job->name_job }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/404.jpg') }}'">
                                <div class="custom-block">
                                    <div class="custom-block-body">
                                        <h5 class="mb-3">{{ $job->name_job ?? '' }}</h5>
                                        <p>{{ $job->company->name }}</p>
                                    </div>

                                    <a href="{{ route('portal.jobs.detail', ['jobId' => $job->id]) }}"
                                        class="custom-btn btn">Detail</a>
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
            align-items: flex-end;
            gap: 2rem;

        }

        .job-form label {
            color: white;
        }
    </style>
@endsection
