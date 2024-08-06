@foreach($comments as $comment)
<li class="single_comment_area">

    <div class="comment-content d-flex">

        <div class="comment-author">
            @if($comment->user_id != '')
            <img src="{{ userAvater($comment->user_id) }}" alt="author">
            @else
            <img src="{{ asset('assets/front/img/core-img/avater.png') }}" alt="author">
            @endif
        </div>
        <div class="comment-meta">
            <a href="#" class="post-date">{{ $comment->created_at->format('Y-m-d') }}</a>
            <h5>{{ $comment->name }}</h5>
            <p>{{ $comment->comment }}</p>
            @if($comment->comment_stars == 1) <i class="star"></i> @endif
            @if($comment->comment_stars == 2) <i class="star"></i> <i class="star"></i> @endif
            @if($comment->comment_stars == 3) <i class="star"></i> <i class="star"></i> <i class="star"></i> @endif
            @if($comment->comment_stars == 4) <i class="star"></i> <i class="star"></i> <i class="star"></i> <i class="star"></i> @endif
            @if($comment->comment_stars == 5) <i class="star"></i> <i class="star"></i> <i class="star"></i> <i class="star"></i> <i class="star"></i> @endif
            {{--<a href="javascript:;" data-id="{{ $comment->id }}" class="reply">Reply</a>--}}
        </div>
    </div>
</li>
    @endforeach