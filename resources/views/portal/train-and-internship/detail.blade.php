@php
    use Carbon\Carbon;
@endphp
@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center"
            style="background-image: url({{ asset('storage/' . $data->image) }});">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">{{ $data->name }}</h1>
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
                                    <h4>{{ $data->name }}</h4>
                                </div>

                                <div class="d-flex mt-2">
                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            {{ Carbon::parse($data->start_date)->format('d M Y') }} -
                                            {{ Carbon::parse($data->end_date)->format('d M Y') }}

                                        </p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p>
                                            <i class="bi-person custom-icon me-1"></i>
                                            {{ $data->type }}
                                        </p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p>
                                            Rp.
                                            {{ number_format(is_string($data->fee) ? 0 : $data->fee, 2) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="news-block-body">
                                    {!! $data->description !!}
                                </div>
                                @if (!is_null($data->requirement))
                                    <div class="news-block-body mt-2">
                                        <h5>Persyaratan Peserta</h5>
                                        {!! $data->requirement !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
