@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center"
            style="background-image: url({{ asset('storage/' . $subMenu->image) }});">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">{{ $subMenu->title }}</h1>
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
                                    <h4>{{ $subMenu->title }}</h4>
                                </div>
                                <div class="d-flex">
                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            {{ $subMenu->created_at_format }}
                                        </p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p>
                                            <i class="bi-person custom-icon me-1"></i>
                                            {{ $subMenu->author }}
                                        </p>
                                    </div>

                                </div>


                                <div class="news-block-body">
                                    {!! $subMenu->body !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
