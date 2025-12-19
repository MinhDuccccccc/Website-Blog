@extends('web.layout.master')

@section('content')

<style>
/* ===== SEARCH PAGE ===== */
.search-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 30px;
}

.search-title span {
    color: #38bdf8;
}

/* Card */
.search-card {
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    margin-bottom: 32px;
    transition: .3s;
}

.search-card:hover {
    transform: translateY(-4px);
}

/* Image */
.search-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/*  FIX MẠNH: padding + spacing */
.search-meta {
    padding: 40px 42px;   /* tăng mạnh */
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.search-meta h4 {
    margin-bottom: 14px;
}

.search-meta h4 a {
    color: #020617;
    font-weight: 600;
    line-height: 1.5;
}

.search-meta p {
    color: #475569;
    margin: 16px 0 20px;
    line-height: 1.7;
    max-width: 95%;
}

/* Category badge */
.bg-orange {
    background: #38bdf8;
    color: #020617 !important;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* Meta info */
.search-meta small {
    margin-right: 16px;
    color: #64748b;
}

/* Sidebar */
.sidebar .widget {
    background: #ffffff;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.widget-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
}

.sidebar ul {
    list-style: none;
    padding-left: 0;
}

.sidebar ul li {
    margin-bottom: 14px;
}

.sidebar ul li a {
    color: #334155;
    font-weight: 500;
}

.sidebar ul li a:hover {
    color: #38bdf8;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
}

/* Mobile */
@media (max-width: 768px) {
    .search-meta {
        padding: 26px;
    }
}
</style>

<section class="section">
    <div class="container">
        <div class="row">

            {{-- SEARCH RESULT --}}
            <div class="col-lg-8">

                <h4 class="search-title">
                    Search results for:
                    <span>"{{ $keyword }}"</span>
                </h4>

                @if($posts->count())

                    @foreach($posts as $post)
                        <div class="search-card">
                            <div class="row no-gutters">

                                <div class="col-md-4 search-thumb">
                                    <a href="{{ route('web.post', $post->slug) }}">
                                        <img src="{{ $post->imageUrl() }}" alt="">
                                    </a>
                                </div>

                                <div class="col-md-8 search-meta">

                                    <h4>
                                        <a href="{{ route('web.post', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </h4>

                                    <p>{{ $post->description }}</p>

                                    <div>
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
                        </div>
                    @endforeach

                    <div class="pagination-wrapper">
                        {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>

                @else
                    <p class="text-muted">No posts found.</p>
                @endif

            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="widget">
                        <h2 class="widget-title">Categories</h2>
                        <ul>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('web.category', $category->slug) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
