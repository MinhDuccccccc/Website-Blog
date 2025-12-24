@extends('web.layout.master')

@section('content')

<style>
/* ================= HOME PAGE ================= */

/* Highlight section */
.first-section {
    margin-top: 90px;
}

/* ===== FEATURED TECH LAYOUT ===== */
.masonry-blog {
    display: grid;
    grid-template-columns: 2fr 1fr;
    grid-template-rows: repeat(2, 260px);
    gap: 20px;
}

.masonry-box {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
}

/* Bài nổi bật */
.masonry-box:first-child {
    grid-row: span 2;
}

/* Image */
.masonry-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .4s;
}

.masonry-box:hover img {
    transform: scale(1.08);
}

/* Shadow */
.shadoweffect {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(2,6,23,0.9),
        rgba(2,6,23,0.25)
    );
}

/* Content */
.shadow-desc {
    position: absolute;
    bottom: 0;
    padding: 22px;
}

.shadow-desc h4 a {
    color: #fff;
    font-weight: 600;
    line-height: 1.3;
}

/* Title size */
.masonry-box:first-child .shadow-desc h4 a {
    font-size: 26px;
}

.masonry-box:not(:first-child) .shadow-desc h4 a {
    font-size: 16px;
}

.shadow-desc small {
    color: #cbd5f5;
    margin-right: 10px;
}

/* Category */
.bg-orange {
    background: #38bdf8;
    color: #020617 !important;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* ===== RECENT NEWS ===== */
.page-wrapper {
    margin-top: 50px;
}

.blog-list {
    margin-bottom: 28px;
}

.blog-box {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
    transition: .3s;
}

.blog-box:hover {
    transform: translateY(-4px);
}

.blog-box img {
    height: 100%;
    object-fit: cover;
}

.blog-meta.big-meta {
    padding: 22px;
}

.blog-meta h4 a {
    color: #020617;
    font-weight: 600;
}

.blog-meta p {
    color: #475569;
    margin: 12px 0;
}

.blog-meta small {
    margin-right: 14px;
    color: #64748b;
}

/* ===== MOBILE ===== */
@media (max-width: 992px) {
    .masonry-blog {
        grid-template-columns: 1fr;
        grid-template-rows: auto;
    }

    .masonry-box:first-child {
        grid-row: auto;
    }

    .masonry-box {
        height: 240px;
    }

    .blog-box img {
        height: auto;
    }
}
</style>

{{-- ================= HIGHLIGHT POSTS ================= --}}
<section class="section first-section">
    <div class="container-fluid">
        <div class="masonry-blog">

            @foreach($highlight as $post)
                <div class="masonry-box">

                    <img src="{{ $post->imageUrl() }}" alt="">

                    <div class="shadoweffect">
                        <div class="shadow-desc">

                            <span class="bg-orange">
                                <a href="{{ route('web.category', $post->category->slug) }}">
                                    {{ $post->category->name }}
                                </a>
                            </span>

                            <h4 class="mt-2">
                                <a href="{{ route('web.post', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <small>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d-m-Y') }}
                            </small>
                            <small>{{ $post->user->name }}</small>

                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ================= RECENT NEWS ================= --}}
<section class="section">
    <div class="container">
        <div class="page-wrapper">

            <div class="blog-top clearfix mb-4">
                <h4 class="pull-left">
                    Recent News <a href="#"><i class="fa fa-rss"></i></a>
                </h4>
            </div>

            @foreach($new as $post)
                <div class="blog-list">
                    <div class="blog-box row no-gutters">

                        <div class="col-md-4">
                            <a href="{{ route('web.post', $post->slug) }}">
                                <img src="{{ $post->imageUrl() }}" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="col-md-8 blog-meta big-meta">

                            <h4>
                                <a href="{{ route('web.post', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <p>{{ $post->description }}</p>

                            <small>
                                <a class="bg-orange"
                                   href="{{ route('web.category', $post->category->slug) }}">
                                    {{ $post->category->name }}
                                </a>
                            </small>

                            <small>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d-m-Y') }}
                            </small>

                            <small>{{ $post->user->name }}</small>

                            <small>
                                <i class="fa fa-eye"></i> {{ $post->view_counts }}
                            </small>

                        </div>

                    </div>
                </div>
            @endforeach
            <div class="row mt-4">
               <div class="col-md-12 text-center">
                 {{ $new->links('pagination::bootstrap-4') }}
               </div>
            </div>
        </div>
    </div>
</section>

@endsection
