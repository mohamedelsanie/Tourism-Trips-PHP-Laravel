
<div class="single-room-review-area d-flex align-items-center">
<div class="reviwer-thumbnail">
    @if($comment->user_id != '')
    <img src="{{ userAvater($comment->user_id) }}" alt="author">
    @else
    <img src="{{ asset('assets/front/img/core-img/avater.png') }}" alt="author">
    @endif
</div>
<div class="reviwer-content">
    <div class="reviwer-title-rating d-flex align-items-center justify-content-between">
        <div class="reviwer-title">
            <span>{{ $comment->created_at->format('Y-m-d') }}</span>
            <h6>{{ $comment->name }}</h6>
        </div>
        <div class="reviwer-rating">
            @if($comment->comment_stars == 1) <i class="fa fa-star"></i> @endif
            @if($comment->comment_stars == 2) <i class="fa fa-star"></i><i class="fa fa-star"></i> @endif
            @if($comment->comment_stars == 3) <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> @endif
            @if($comment->comment_stars == 4) <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> @endif
            @if($comment->comment_stars == 5) <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> @endif
        </div>
    </div>
    <p>{{ $comment->comment }}</p>
</div>
</div>
