
<div class="comment-content d-flex">

    <div class="comment-author">
        @if($comment->user_id != '')
        <img src="{{ userAvater($comment->user_id) }}" alt="author">
        @else
        <img src="{{ asset('assets/front/img/core-img/avater.png') }}" alt="author">
        @endif
    </div>

    <div class="comment-meta">
        <a class="post-date">{{ $comment->created_at->format('Y-m-d') }}</a>
        <h5>{{ $comment->name }}</h5>
        <p>{{ $comment->comment }}</p>
        @if($comment->comment_stars == 1) <i class="star"></i> @endif
        @if($comment->comment_stars == 2) <i class="star"></i> <i class="star"></i> @endif
        @if($comment->comment_stars == 3) <i class="star"></i> <i class="star"></i> <i class="star"></i> @endif
        @if($comment->comment_stars == 4) <i class="star"></i> <i class="star"></i> <i class="star"></i> <i class="star"></i> @endif
        @if($comment->comment_stars == 5) <i class="star"></i> <i class="star"></i> <i class="star"></i> <i class="star"></i> <i class="star"></i> @endif
        <br>
        @if(getSetting('testimonials_page') != $page->id)
        <a href="#addComment" data-id="{{ $comment->id }}" class="reply">{{ __('front/post_types.comments.reply') }}</a>
        @endif
    </div>
</div>