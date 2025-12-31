<div class="comment-item {{ $level > 0 ? 'comment-reply' : '' }}">
    <div class="comment-header">
        <div>
            <span class="comment-author">{{ $comment->user->name }}</span>
            <span class="comment-time">· {{ $comment->created_at->format('d-m-Y H:i') }}</span>
        </div>

        @auth
            @if($level < 4 && $comment->replies->count())
                <span class="reply-btn" onclick="toggleReplyList({{ $comment->id }})">
                    {{ $comment->replies->count() }} replies
                </span>
            @endif
            @if($level < 4)
                <span class="reply-btn" onclick="toggleReplyForm({{ $comment->id }})">Reply</span>
            @endif
        @endauth
    </div>

    <div class="comment-content">{{ $comment->content }}</div>

    @auth
        @if($level < 4)
            <form method="POST"
                  action="{{ route('web.post.comment', $post->id) }}"
                  id="reply-form-{{ $comment->id }}"
                  class="reply-form mt-2"
                  style="display:none">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                <textarea name="content"
                          class="form-control"
                          rows="2"
                          placeholder="Write a reply..."
                          required></textarea>
                <button class="btn btn-sm btn-outline-primary mt-2">Send</button>
            </form>
        @endif
    @endauth

    {{-- REPLIES --}}
    @if($comment->replies->count())
        <div id="reply-list-{{ $comment->id }}" style="display:none; margin-top:10px;">
            @foreach($comment->replies as $reply)
                @include('web.partials.comment', [
                    'comment' => $reply,
                    'level' => $level + 1,
                    'post' => $post
                ])
            @endforeach
        </div>
    @endif
</div>
