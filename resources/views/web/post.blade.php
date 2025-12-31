@extends('web.layout.master')

@section('content')

<style>
/* ===== POST DETAIL ===== */
.single-wrapper { margin-top: 90px; }
.blog-title-area { margin-bottom: 30px; }
.blog-title-area h3 { font-size: 32px; font-weight: 700; margin: 16px 0; line-height: 1.4; }
.blog-meta.big-meta small { margin-right: 16px; color: #64748b; }
.single-post-media img { border-radius: 18px; margin: 30px 0; }
.blog-content { background: #ffffff; border-radius: 20px; padding: 42px 48px; box-shadow: 0 12px 35px rgba(0,0,0,.08); }
.blog-content p { font-size: 16px; line-height: 1.9; color: #334155; margin-bottom: 22px; }
.custombox { margin-top: 60px; }
.custombox .small-title { font-size: 22px; font-weight: 600; margin-bottom: 30px; }
.custombox .blog-box { border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,.08); transition: .3s; }
.custombox .blog-box:hover { transform: translateY(-4px); }
.custombox .blog-meta { padding: 20px; }

/* COMMENTS */
.comments-list .comment-item { background: #f8fafc; border-radius: 16px; padding: 16px; margin-bottom: 15px; }
.comment-reply { margin-left: 30px; }
.comment-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.comment-author { font-weight: 600; }
.comment-time { color: #64748b; margin-left: 6px; }
.reply-btn { font-size: 13px; color: #2563eb; cursor: pointer; margin-left: 6px; }
.comment-content { margin-top: 4px; color: #475569; line-height: 1.6; }
.reply-form textarea { width: 100%; border-radius: 8px; padding: 6px; font-size: 14px; }
.reply-form button { border-radius: 999px; padding: 4px 14px; }

.sidebar .widget { background: #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,.08); }
.widget-title { font-size: 20px; font-weight: 600; margin-bottom: 25px; }

@media (max-width: 768px) {
    .blog-title-area h3 { font-size: 24px; }
    .blog-content { padding: 26px; }
}
</style>

<section class="section single-wrapper">
    <div class="container">
        <div class="row">

            {{-- MAIN --}}
            <div class="col-lg-9">
                <div class="page-wrapper">

                    {{-- TITLE --}}
                    <div class="blog-title-area text-center">
                        <ol class="breadcrumb hidden-xs-down justify-content-center">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/category">Blog</a></li>
                            <li class="breadcrumb-item active">{{ $post->title }}</li>
                        </ol>

                        <span class="color-orange">
                            <a href="{{ route('web.category', $post->category->slug) }}">
                                {{ $post->category->name }}
                            </a>
                        </span>

                        <h3>{{ $post->title }}</h3>

                        <div class="blog-meta big-meta">
                            <small>{{ $post->created_at->format('d-m-Y') }}</small>
                            <small>{{ $post->user->name }}</small>
                            <small><i class="fa fa-eye"></i> {{ $post->view_counts }}</small>
                        </div>
                    </div>

                    {{-- IMAGE --}}
                    <div class="single-post-media">
                        <img src="{{ $post->imageUrl() }}" class="img-fluid">
                    </div>

                    {{-- CONTENT --}}
                    <div class="blog-content">
                        <p><strong>{{ $post->description }}</strong></p>
                        {!! $post->content !!}
                    </div>

                    {{-- RELATED --}}
                    <div class="custombox clearfix">
                        <h4 class="small-title">You may also like</h4>
                        <div class="row">
                            @foreach($relate as $item)
                                <div class="col-lg-6 mb-4">
                                    <div class="blog-box">
                                        <div class="post-media">
                                            <a href="{{ route('web.post', $item->slug) }}">
                                                <img src="{{ $item->imageUrl() }}" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="blog-meta">
                                            <h4>
                                                <a href="{{ route('web.post', $item->slug) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </h4>
                                            <small>{{ $item->created_at->format('d-m-Y') }}</small>
                                            <small>{{ $item->user->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- COMMENTS --}}
                    <div class="custombox clearfix">
                        <h4 class="small-title">{{ $post->comments()->count() }} Comments</h4>
                        <div class="comments-list">
                            @foreach($comments as $comment)
                                @include('web.partials.comment', [
                                    'comment' => $comment,
                                    'level' => 0,
                                    'post' => $post
                                ])
                            @endforeach

                            {{-- PAGINATION --}}
                            <div class="mt-3">
                                {{ $comments->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>

                    {{-- COMMENT FORM --}}
                    @auth
                        <div class="custombox clearfix">
                            <h4 class="small-title">Leave a Comment</h4>
                            <form class="form-wrapper" method="post" action="{{ route('web.post.comment', $post->id) }}">
                                @csrf
                                <textarea class="form-control"
                                          id="comment-content"
                                          name="content"
                                          placeholder="Write your comment..."
                                          required></textarea>
                                <button type="submit"
                                        class="btn btn-primary mt-3"
                                        id="submit-comment"
                                        disabled>
                                    Submit Comment
                                </button>
                            </form>
                        </div>
                    @endauth

                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="widget">
                        <h2 class="widget-title">Popular Posts</h2>
                        @foreach($highlight as $item)
                            <div class="blog-box mb-4">
                                <div class="post-media">
                                    <a href="{{ route('web.post', $item->slug) }}">
                                        <img src="{{ $item->imageUrl() }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="blog-meta">
                                    <h4>
                                        <a href="{{ route('web.post', $item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.getElementById("comment-content");
    const submitBtn = document.getElementById("submit-comment");

    if (textarea) {
        textarea.addEventListener("input", function () {
            submitBtn.disabled = textarea.value.trim().length === 0;
        });
    }
});

function toggleReplyForm(commentId) {
    const form = document.getElementById('reply-form-' + commentId);
    form.style.display = form.style.display === 'block' ? 'none' : 'block';
}

function toggleReplyList(commentId) {
    const list = document.getElementById('reply-list-' + commentId);
    list.style.display = list.style.display === 'block' ? 'none' : 'block';
}
</script>

@endsection
