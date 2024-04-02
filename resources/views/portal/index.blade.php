@extends('layouts.portal.app')

@section('content')
    <main>
        <section class="hero-section hero-section-full-height">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-lg-12 col-12 p-0">
                        <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($dashboard?->images ?? [] as $image)
                                    <div class="carousel-item active">
                                        <img src="{{ asset('storage/' . $image->image) }}" class="carousel-image img-fluid"
                                            alt="...">

                                        <div class="carousel-caption d-flex flex-column justify-content-end">
                                            <h1>{{ $image->title }}</h1>

                                            <p>{{ $image->subtitle }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#hero-slide"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <section class="section-padding" id="unit-layanan">
            <div class="container">
                <div class="row d-flex justify-content-center">

                    <div class="col-lg-10 col-12 text-center mx-auto">
                        <h2 class="mb-5">Visi</h2>
                    </div>

                    @forelse ($dashboard?->visions ?? [] as $vision)
                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                            <div class="featured-block d-flex justify-content-center align-items-center">
                                <a href="#" class="d-block">
                                    <img src="{{ asset('storage/' . $vision->image) }}"
                                        class="featured-block-image img-fluid" alt="">

                                    <p class="featured-block-text">{{ $vision->title }}</p>
                                </a>
                            </div>
                        </div>
                    @empty
                        <h5>No Data Available</h5>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="section-padding section-bg" id="profil">
            <div class="container">
                <div class="row">

                    <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                        <img src="{{ asset($dashboard?->our_story_image ? "storage/{$dashboard->our_story_image}" : 'portal/images/group-people-volunteering-foodbank-poor-people.jpg') }}"
                            class="custom-text-box-image img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="custom-text-box">
                            <h2 class="mb-2">Our Story</h2>

                            <h5 class="mb-3">Digital Palangka Raya Kreatif Ketenagakerjaan</h5>

                            <p class="mb-0">{!! $dashboard?->short_description ?? '' !!}</p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="custom-text-box mb-lg-0">
                                    <h5 class="mb-3">Our Mission</h5>

                                    <p>{!! $dashboard->mission ?? '' !!}</p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="custom-text-box d-flex flex-wrap d-lg-block mb-lg-0">
                                    <div class="counter-thumb">
                                        <div class="d-flex">
                                            <span class="counter-number" data-from="1" data-to="{{ $total['pekerjaan'] }}"
                                                data-speed="1000"></span>
                                            <span class="counter-number-text"></span>
                                        </div>

                                        <span class="counter-text">Lowongan Pekerjaan</span>
                                    </div>

                                    <div class="counter-thumb mt-4">
                                        <div class="d-flex">
                                            <span class="counter-number" data-from="1" data-to="{{ $total['perusahaan'] }}"
                                                data-speed="1000"></span>
                                            <span class="counter-number-text"></span>
                                        </div>

                                        <span class="counter-text">Perusahaan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        @if (!is_null($departementMember))
            <section class="about-section section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-md-5 col-12">
                            <img src="{{ asset('storage/' . $departementMember->image) }}"
                                class="about-image ms-lg-auto bg-light shadow-lg img-fluid" alt="">
                        </div>

                        <div class="col-lg-5 col-md-7 col-12">
                            <div class="custom-text-block">
                                <h2 class="mb-0">{{ $departementMember->name }}</h2>

                                <p class="text-muted mb-lg-4 mb-md-4">{{ $departementMember->position }}</p>

                                <p>{!! $departementMember->description !!}</p>

                                @php
                                    $socials = ['facebook', 'twitter', 'instagram'];
                                @endphp
                                <ul class="social-icon mt-4">
                                    @foreach ($socials as $social)
                                        @if (!is_null($departementMember->$social))
                                            <li class="social-icon-item">
                                                <a href="{{ $departementMember->$social }}"
                                                    class="social-icon-link bi-{{ $social }}"></a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        @endif
        <section class="cta-section section-padding section-bg">
            <div class="container">
                <div class="row justify-content-center align-items-center">

                    <div class="col-12">
                        <h2 class="mb-0">{!! $dashboard->quote ?? '' !!}</h2>
                    </div>

                    <div class="col-12">
                    </div>

                </div>
            </div>
        </section>

        <section class="section-padding" id="pekerjaan">
            <div class="container">
                <div class="row d-flex justify-content-center">

                    <div class="col-lg-12 col-12 text-center mb-4">
                        <h2>Pekerjaan</h2>
                    </div>

                    @forelse ($jobs as $job)
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


        @if (!is_null($dashboard?->testimonials))
            <section class="testimonial-section section-padding section-bg">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h2 class="mb-lg-3">Happy customers</h2>

                            <div id="testimonial-carousel" class="carousel carousel-fade slide" data-bs-ride="carousel">

                                <div class="carousel-inner">
                                    @foreach ($dashboard?->testimonials ?? [] as $key => $testimonial)
                                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                            <div class="carousel-caption">
                                                <h4 class="carousel-title">{{ $testimonial->testimonial }}</h4>

                                                <small class="carousel-name"><span
                                                        class="carousel-name-title">{{ $testimonial->name }}</span>,
                                                    {{ $testimonial->job }}</small>
                                            </div>
                                        </div>
                                    @endforeach


                                    <ol class="carousel-indicators">
                                        @foreach ($dashboard?->testimonials ?? [] as $key => $testimonial)
                                            <li data-bs-target="#testimonial-carousel"
                                                data-bs-slide-to="{{ $key }}"
                                                class="{{ $key === 0 ? 'active' : '' }}">
                                                <img src="{{ !is_null($testimonial->image) ? asset('storage/' . $testimonial->image) : asset('portal/images/avatar/portrait-beautiful-young-woman-standing-grey-wall.jpg') }}"
                                                    class="img-fluid rounded-circle avatar-image" alt="avatar">
                                            </li>
                                        @endforeach
                                    </ol>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        @endif

        <section class="news-section section-padding" id="news">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 mb-5">
                        <h2>Latest News</h2>
                    </div>

                    <div class="col-lg-7 col-12">
                        @forelse ($news->slice(0, 2) as $new)
                            <div class="news-block" style="margin-bottom:5rem">
                                <div class="news-block-top">
                                    <a href="{{ route('portal.news.detail', ['slug' => $new->slug]) }}">
                                        <img src="{{ asset('storage/' . $new->image) }}" class="news-image img-fluid"
                                            alt="">
                                    </a>

                                    <div class="news-category-block">
                                        <a href="#" class="category-block-link">
                                            {{ $new->category->name }}
                                        </a>
                                    </div>
                                </div>

                                <div class="news-block-info">
                                    <div class="d-flex mt-2">
                                        <div class="news-block-date">
                                            <p>
                                                <i class="bi-calendar4 custom-icon me-1"></i>
                                                {{ $new->created_at_format }}
                                            </p>
                                        </div>

                                        <div class="news-block-author mx-5">
                                            <p>
                                                <i class="bi-person custom-icon me-1"></i>
                                                By {{ $new->author }}
                                            </p>
                                        </div>

                                        <div class="news-block-comment">
                                            <p>
                                                <i class="bi-chat-left custom-icon me-1"></i>
                                                {{ $new->comments->count() }} Comments
                                            </p>
                                        </div>
                                    </div>

                                    <div class="news-block-title mb-2">
                                        <h4><a href="{{ route('portal.news.detail', ['slug' => $new->slug]) }}"
                                                class="news-block-title-link">{{ $new->title }}</a></h4>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <h5>No Data Available</h5>
                        @endforelse
                    </div>

                    <div class="col-lg-4 col-12 mx-auto">
                        <form class="custom-form search-form" action="{{ route('portal.news.index') }}" method="get"
                            role="form">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                name="q">

                            <button type="submit" class="form-control">
                                <i class="bi-search"></i>
                            </button>
                        </form>


                        <h5 class="mt-5 mb-3">Recent news</h5>

                        @forelse ($news->slice(2, 4) as $new)
                            <div class="news-block news-block-two-col d-flex mt-4">
                                <div class="news-block-two-col-image-wrap">
                                    <a href="{{ route('portal.news.detail', ['slug' => $new->slug]) }}">
                                        <img src="{{ asset('storage/' . $new->image) }}" class="news-image img-fluid"
                                            alt="">
                                    </a>
                                </div>

                                <div class="news-block-two-col-info">
                                    <div class="news-block-title mb-2">
                                        <h6><a href="{{ route('portal.news.detail', ['slug' => $new->slug]) }}"
                                                class="news-block-title-link">{{ $new->title }}</a>
                                        </h6>
                                    </div>

                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            {{ $new->created_at_format }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No Data Available</p>
                        @endforelse
                        <div class="category-block d-flex flex-column">
                            <h5 class="mb-3">Categories</h5>

                            @foreach ($categories as $category)
                                <a href="{{ route('portal.news.index', ['category' => $category->name]) }}"
                                    class="category-block-link">
                                    {{ $category->name }}
                                    <span class="badge">{{ $category->news->count() }}</span>
                            @endforeach
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
