@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center"
            style="background-image: url({{ asset('storage/' . $berita->image) }});">
            >
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">Berita</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-7 col-12">
                        <div class="news-block">
                            <div class="news-block-top">
                                <img src="{{ asset('storage/' . $berita->image) }}" class="news-image img-fluid"
                                    alt="">

                                <div class="news-category-block">
                                    <a href="#" class="category-block-link">
                                        {{ $berita->category->name }}
                                    </a>
                                </div>
                            </div>

                            <div class="news-block-info">
                                <div class="d-flex mt-2">
                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            {{ $berita->created_at_format }}
                                        </p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p>
                                            <i class="bi-person custom-icon me-1"></i>
                                            By {{ $berita->author }}
                                        </p>
                                    </div>

                                    <div class="news-block-comment">
                                        <p>
                                            <i class="bi-chat-left custom-icon me-1"></i>
                                            {{ $berita->comments->count() }} Comments
                                        </p>
                                    </div>
                                </div>

                                <div class="news-block-title mb-2">
                                    <h4>{{ $berita->title }}</h4>
                                </div>

                                <div class="news-block-body">
                                    {!! $berita->body !!}
                                </div>


                                <div class="social-share border-top mt-5 py-4 d-flex flex-wrap align-items-center">
                                    <div class="tags-block me-auto">
                                        @foreach ($berita->tags as $tag)
                                            <a href="#" class="tags-block-link">
                                                {{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>

                                    <!-- <div class="d-flex"> -->
                                    <!--     <a href="#" class="social-icon-link bi-facebook"></a> -->
                                    <!---->
                                    <!--     <a href="#" class="social-icon-link bi-twitter"></a> -->
                                    <!---->
                                    <!--     <a href="#" class="social-icon-link bi-printer"></a> -->
                                    <!---->
                                    <!--     <a href="#" class="social-icon-link bi-envelope"></a> -->
                                    <!-- </div> -->
                                </div>

                                @forelse ($berita->comments as $comment)
                                    <div class="author-comment d-flex mt-3 mb-4">
                                        <img src="{{ asset('portal/images/avatar/studio-portrait-emotional-happy-funny.jpg') }}"
                                            class="img-fluid avatar-image" alt="">

                                        <div class="author-comment-info ms-3">
                                            <h6 class="mb-1">{{ $comment->name }} </h6>

                                            <p class="mb-0">{{ $comment->comment }} </p>
                                        </div>
                                    </div>
                                @empty
                                    <p>No Comments</p>
                                @endforelse
                                <div class="mb-5"></div>

                                <form class="custom-form comment-form mt-4" action="#" method="post" role="form">
                                    <h6 class="mb-3">Write a comment</h6>
                                    <input type="text" name="name" class="form-control mb-3" placeholder="Your name"
                                        required />

                                    <textarea name="comment-message" rows="4" class="form-control" id="comment-message"
                                        placeholder="Your comment here"></textarea>

                                    <div class="col-lg-3 col-md-4 col-6 ms-auto">
                                        <button type="submit" class="form-control">Comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 mx-auto">
                        <form class="custom-form search-form" action="{{ route('portal.berita.index') }}" method="get"
                            role="form">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                name="q">

                            <button type="submit" class="form-control">
                                <i class="bi-search"></i>
                            </button>
                        </form>


                        <h5 class="mt-5 mb-3">Recent news</h5>

                        @if (count($news->slice(2, 4)))
                            @foreach ($news->slice(2, 4) as $new)
                                <div class="news-block news-block-two-col d-flex mt-4">
                                    <div class="news-block-two-col-image-wrap">
                                        <a href="{{ route('portal.berita.detail', ['slug' => $new->slug]) }}">
                                            <img src="{{ asset('storage/' . $new->image) }}" class="news-image img-fluid"
                                                alt="">
                                        </a>
                                    </div>

                                    <div class="news-block-two-col-info">
                                        <div class="news-block-title mb-2">
                                            <h6><a href="{{ route('portal.berita.detail', ['slug' => $new->slug]) }}"
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
                            @endforeach
                        @else
                            <p>-</p>
                        @endif


                        <div class="category-block d-flex flex-column">
                            <h5 class="mb-3">Categories</h5>

                            @foreach ($categories as $category)
                                <a href="{{ route('portal.berita.index', ['category' => $category->name]) }}"
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

        <section class="news-section section-padding section-bg">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 mb-4">
                        <h2>Related news</h2>
                    </div>

                    @forelse ($relatedBerita as $rb)
                        <div class="col-lg-6 col-12">
                            <div class="news-block">
                                <div class="news-block-top">
                                    <a href="news-detail.html">
                                        <img src="{{ asset('storage/' . $rb->image) }}" class="news-image img-fluid"
                                            alt="">
                                    </a>

                                    <div class="news-category-block">
                                        <a href="#" class="category-block-link">
                                            {{ $rb->category->name }}
                                        </a>
                                    </div>
                                </div>

                                <div class="news-block-info">
                                    <div class="d-flex mt-2">
                                        <div class="news-block-date">
                                            <p>
                                                <i class="bi-calendar4 custom-icon me-1"></i>
                                                {{ $rb->created_at_format }}
                                            </p>
                                        </div>

                                        <div class="news-block-author mx-5">
                                            <p>
                                                <i class="bi-person custom-icon me-1"></i>
                                                By {{ $rb->author }}
                                            </p>
                                        </div>

                                        <div class="news-block-comment">
                                            <p>
                                                <i class="bi-chat-left custom-icon me-1"></i>
                                                {{ $rb->comments->count() }} Comments
                                            </p>
                                        </div>
                                    </div>

                                    <div class="news-block-title mb-2">
                                        <h4><a href="{{ route('portal.berita.detail', ['slug' => $rb->slug]) }} "
                                                class="news-block-title-link">{{ $rb->title }} </a></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h5>No Data Available</h5>
                    @endforelse



                </div>
            </div>
        </section>
    </main>
@endsection
