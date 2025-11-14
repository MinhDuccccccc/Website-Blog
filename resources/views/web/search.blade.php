@extends('web.layout.master')

@section('content')
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="mb-4">Search results for: <strong>{{ $keyword }}</strong></h4>

                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <div class="blog-list clearfix">
                            <div class="blog-box row">
                                <div class="col-md-4">
                                    <div class="post-media">
                                        <a href="{{ route('web.post', $post->slug) }}" title="">
                                            <img src="{{ $post->imageUrl() }}" alt="" class="img-fluid">
                                            <div class="hovereffect"></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="blog-meta big-meta col-md-8">
                                    <h4><a href="{{ route('web.post', $post->slug) }}" title="">{{ $post->title }}</a></h4>
                                    <p>{{ $post->description }}</p>
                                    <small class="firstsmall">
                                        <a class="bg-orange" href="{{ route('web.category', $post->category->slug) }}" title="">
                                            {{ $post->category->name }}
                                        </a>
                                    </small>
                                    <small>{{ \Carbon\Carbon::parse($post->created_at)->format('d-m-Y') }}</small>
                                    <small>{{ $post->user->name }}</small>
                                    <small><i class="fa fa-eye"></i> {{ $post->view_counts }}</small>
                                </div>
                            </div>
                            <hr class="invis">
                        </div>
                    @endforeach

                    <div class="pagination-wrapper">
                        {{ $posts->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <p>No posts found matching this keyword.</p>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="widget">
                        <h2 class="widget-title">Categories</h2>
                        <ul>
                            @foreach($categories as $category)
                                <li><a href="{{ route('web.category', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
