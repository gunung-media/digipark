@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12">
                        @php

                            $titleName = $name ? $name : 'Semua Berita';
                            if ($category) {
                                $titleName .= " Kategori $category";
                            }

                        @endphp
                        <h1 class="text-white">{{ $titleName }}</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-7 col-12">

                        @forelse ($news as $new)
                            <div class="news-block mt-3">
                                <div class="news-block-top">
                                    <a href="{{ route('portal.berita.detail', ['slug' => $new->slug]) }}">
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
                                        <h4><a href="{{ route('portal.berita.detail', ['slug' => $new->slug]) }}"
                                                class="news-block-title-link">{{ $new->title }}</a></h4>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <h5>No Data Available </h5>
                        @endforelse
                    </div>

                    <div class="col-lg-4 col-12 mx-auto mt-4 mt-lg-0">
                        <form class="custom-form search-form" action="{{ route('portal.berita.index') }}" method="get"
                            role="form">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                name="q">

                            <button type="submit" class="form-control">
                                <i class="bi-search"></i>
                            </button>
                        </form>

                        <div class="category-block d-flex flex-column">
                            <h5 class="mb-3">Categories</h5>

                            @forelse ($categories as $category)
                                <a href="{{ route('portal.berita.index', ['category' => $category->name]) }}"
                                    class="category-block-link">
                                    {{ $category->name }}
                                    <span class="badge">{{ $category->news->count() }}</span>
                                </a>
                            @empty
                                <p>No Data Available </p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
