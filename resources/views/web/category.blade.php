@extends('web.layout.master')

@section('content')

<style>
/* ===== CATEGORY PAGE ===== */
.category-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 36px;
}

.category-title span {
    color: #0ea5e9;
}

/* ===== POST ITEM ===== */
.category-item {
    display: flex;
    gap: 24px;
    padding: 28px;
    background: #ffffff;
    border-radius: 16px;
    margin-bottom: 28px;
    box-shadow: 0 6px 24px rgba(0,0,0,.06);
    transition: .25s;
}

.category-item:hover {
    transform: translateY(-3px);
}

/* Image */
.category-thumb {
    width: 240px;
    flex-shrink: 0;
}

.category-thumb img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 12px;
}

/* Content */
.category-content {
    flex: 1;
    padding-right: 10px;
}

.category-content h4 {
    margin-bottom: 12px;
}

.category-content h4 a {
    color: #020617;
    font-weight: 600;
    line-height: 1.45;
}

.category-content p {
    color: #475569;
    line-height: 1.7;
    margin-bottom: 16px;
}

/* Meta */
.category-meta small {
    color: #64748b;
    margin-right: 14px;
}

.category-meta .badge-category {
    background: #e0f2fe;
    color: #0369a1 !important;
    padding: 5px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

/* Sidebar */
.sidebar .widget {
    background: #ffffff;
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
.pagination-custom {
    margin-top: 40px;
}

/* Mobile */
@media (max-width: 768px) {
    .category-item {
        flex-direction: column;
        padding: 22px;
    }

    .category-thumb {
        width: 100%;
    }

    .category-thumb img {
        height: 200px;
    }
}
</style>

<section class="section">
    <div class="container mt-5">
        <div class="row">

            {{-- SIDEBAR --}}
            <div class="col-lg-3 col-md-12">
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

            {{-- CATEGORY POSTS --}}
            <div class="col-lg-9 col-md-12">

                <h4 class="category-title">
                    Category:
                    <span>{{ $currentCategory->name ?? '' }}</span>
                </h4>

                @foreach($posts as $post)
                    <div class="category-item">

                        <div class="category-thumb">
                            <a href="{{ route('web.post', $post->slug) }}">
                                <img src="{{ $post->imageUrl() }}" alt="">
                            </a>
                        </div>

                        <div class="category-content">
                            <h4>
                                <a href="{{ route('web.post', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h4>

                            <p>{{ $post->description }}</p>

                            <div class="category-meta">
                                <small>
                                    <a class="badge-category"
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

                <div class="pagination-custom">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
