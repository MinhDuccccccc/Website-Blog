@extends('web.layout.master')

@section('content')

<style>
/* ===== SEARCH PAGE ===== */
.search-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 36px;
}

.search-title span {
    color: #0ea5e9;
}

/* ===== SEARCH ITEM ===== */
.search-item {
    display: flex;
    gap: 24px;
    padding: 28px;
    background: #fff;
    border-radius: 16px;
    margin-bottom: 28px;
    box-shadow: 0 6px 24px rgba(0,0,0,.06);
    transition: .25s;
}

.search-item:hover {
    transform: translateY(-3px);
}

/* Image */
.search-thumb {
    width: 240px;
    flex-shrink: 0;
}

.search-thumb img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
}

/* Content */
.search-content {
    flex: 1;
    padding-right: 10px;
}

.search-content h4 {
    margin-bottom: 12px;
}

.search-content h4 a {
    color: #020617;
    font-weight: 600;
    line-height: 1.45;
}

.search-content p {
    color: #475569;
    line-height: 1.7;
    margin-bottom: 16px;
}

/* Meta */
.search-meta small {
    color: #64748b;
    margin-right: 14px;
}

.search-meta .category {
    background: #e0f2fe;
    color: #0369a1 !important;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* Sidebar */
.sidebar .widget {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 6px 24px rgba(0,0,0,.06);
}

.widget-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 18px;
}

.sidebar ul {
    list-style: none;
    padding-left: 0;
}

.sidebar ul li {
    margin-bottom: 12px;
}

.sidebar ul li a {
    color: #334155;
    font-weight: 500;
}

.sidebar ul li a:hover {
    color: #0ea5e9;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
}

/* Mobile */
@media (max-width: 768px) {
    .search-item {
        flex-direction: column;
        padding: 22px;
    }

    .search-thumb {
        width: 100%;
    }

    .search-thumb img {
        height: 200px;
    }
}
</style>

<section class="section">
    <div class="container">
        <div class="row">

            {{-- SEARCH RESULTS --}}
            <div class="col-lg-8">

                <h4 class="search-title">
                    Search results for <span>"{{ $keyword }}"</span>
                </h4>

                @if($posts->count())

                    @foreach($posts as $post)
                        <div class="search-item">

                            <div class="search-thumb">
                                <a href="{{ route('web.post', $post->slug) }}">
                                    <img src="{{ $post->imageUrl() }}" alt="">
                                </a>
                            </div>

                            <div class="search-content">
                                <h4>
                                    <a href="{{ route('web.post', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h4>

                                <p>{{ $post->description }}</p>

                                <div class="search-meta">
                                    <small>
                                        <a class="category"
                                           href="{{ route('web.category', $post->category->slug) }}">
                                            {{ $post->category->name }}
                                        </a>
                                    </small>

                                    <small>{{ $post->user->name }}</small>
                                    <small>{{ $post->created_at->format('d-m-Y') }}</small>
                                    <small><i class="fa fa-eye"></i> {{ $post->view_counts }}</small>
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
