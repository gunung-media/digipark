@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">Informasi Pelatihan Kerja di LPK</h1>
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
                                    <h4>Informasi Pelatihan Kerja di LPK</h4>
                                </div>
                                <div class="d-flex">
                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            October 12, 2036
                                        </p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p>
                                            <i class="bi-person custom-icon me-1"></i>
                                            By Admin
                                        </p>
                                    </div>

                                </div>


                                <div class="news-block-body">
                                    <p><strong>Lorem Ipsum</strong> dolor sit amet, consectetur adipsicing kengan omeg
                                        kohm tokito Professional charity theme based on Bootstrap</p>

                                    <p><strong>Sed leo</strong> nisl, This is a Bootstrap 5.2.2 CSS template for charity
                                        organization websites. You can feel free to use it. Please tell your friends
                                        about TemplateMo website. Thank you.</p>

                                    <blockquote>Sed leo nisl, posuere at molestie ac, suscipit auctor mauris. Etiam quis
                                        metus elementum, tempor risus vel, condimentum orci.</blockquote>
                                </div>

                                <div class="row mt-5 mb-4">
                                    <div class="col-lg-6 col-12 mb-4 mb-lg-0">
                                        <img src="{{ asset('portal/images/news/africa-humanitarian-aid-doctor.jpg') }}"
                                            class="news-detail-image img-fluid" alt="">
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <img src="{{ asset('portal/images/news/close-up-happy-people-working-together.jpg') }}"
                                            class="news-detail-image img-fluid" alt="">
                                    </div>
                                </div>

                                <p>You are not allowed to redistribute this template ZIP file on any other template
                                    collection website. Please <a href="https://templatemo.com/contact"
                                        target="_blank">contact TemplateMo</a> for more information.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
