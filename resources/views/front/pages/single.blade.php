
<div class="roberto-news-area section-padding-100-0">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-8">

                <div class="post-thumbnail mb-50">
                    <img src="{{ $page->image }}" alt="{{ $page->title }}">
                </div>

                <div class="blog-details-text">
                    <p>{!! $page->content !!}</p>
                </div>

                <div class="post-author-area d-flex align-items-center justify-content-between mb-50">

                    <div class="author-social-info d-flex align-items-center">
                        <p>{{ __('front/post_types.page.share') }} :</p>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ getPageLink($page->id) }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ getPageLink($page->id) }}&text={{ $page->title }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="https://plus.google.com/share?url={{ getPageLink($page->id) }}" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                        <a href="{{ getPageLink(getSetting('contact_page')) }}" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                    </div>
                </div>
                @if(getSetting('comments_mode') == 'open')
                    @if($page->comments_status == 'open')
                        <div class="comment_area mb-50 clearfix">
                            <h2>@if(!empty($comments)){{ count($comments) }}@else 0 @endif {{ __('front/post_types.comments.title') }}</h2>
                            <ol>
                                @foreach($comments as $comment)
                                    {{-- show the comment markup --}}
                                    <li class="single_comment_area">
                                        @include('front.pages.parent-comment', ['comment' => $comment])
                                    </li>
                                    @if($comment->children->count() > 0)
                                        <ol class="children">
                                            {{-- recursively include this view, passing in the new collection of comments to iterate --}}
                                            @include('front.pages.child-comment', ['comments' => $comment->children])
                                        </ol>
                                    @endif
                                @endforeach
                            </ol>
                        </div>

                        <div class="roberto-contact-form mt-80 mb-100" id="addComment">
                            <h2>{{ __('front/post_types.comments.add') }}</h2>
                            <form action="{{ route('page.add_comment',$page->slug) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        @auth()
                                        <input type="text" name="name" value="{{ old('name') ? old('name') : auth()->user()->name }}" class="form-control mb-30" placeholder="{{ __('front/post_types.comments.name') }}">
                                        @else
                                            <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" class="form-control mb-30 @error('name')  border border-danger @enderror" placeholder="{{ __('front/post_types.comments.name') }}">
                                        @endif
                                        @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-12">
                                        @auth()
                                        <input type="email" name="email" value="{{ old('email') ? old('email') : auth()->user()->email }}" class="form-control mb-30" placeholder="{{ __('front/post_types.comments.email') }}">
                                        @else
                                            <input type="email" name="email" value="{{ old('email') ? old('email') : '' }}" class="form-control mb-30 @error('email')  border border-danger @enderror" placeholder="{{ __('front/post_types.comments.email') }}">
                                        @endif
                                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-12">
                                        <textarea name="comment" class="form-control mb-30 @error('comment')  border border-danger @enderror" placeholder="{{ __('front/post_types.comments.comment') }}"></textarea>
                                        @error('comment')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-12">
                                        <ul class="rate-area">
                                            <input type="radio" id="5-star" name="comment_stars" value="5" /><label for="5-star" title="Amazing">5 stars</label>
                                            <input type="radio" id="4-star" name="comment_stars" value="4" /><label for="4-star" title="Good">4 stars</label>
                                            <input type="radio" id="3-star" name="comment_stars" value="3" /><label for="3-star" title="Average">3 stars</label>
                                            <input type="radio" id="2-star" name="comment_stars" value="2" /><label for="2-star" title="Not Good">2 stars</label>
                                            <input type="radio" id="1-star" name="comment_stars" value="1" /><label for="1-star" title="Bad">1 star</label>
                                        </ul>
                                    </div>
                                    <input name="page_id" type="text" class="hidden" value="{{ $page->id }}" />
                                    <div class="col-12">
                                        <button type="submit" class="btn roberto-btn btn-3 mt-15">{{ __('front/post_types.comments.post') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="comment_area mb-50 clearfix">
                            <h3>{{ __('front/post_types.comments.closed') }}</h3>
                        </div>
                    @endif
                @else
                    <div class="comment_area mb-50 clearfix">
                        <h3>{{ __('front/post_types.comments.closed') }}</h3>
                    </div>
                @endif

            </div>
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="roberto-sidebar-area pl-md-4">

                    <div class="single-widget-area mb-100">
                        <div class="newsletter-form">
                            <h5>{{ __('front/post_types.widgets.newsletter_title') }}</h5>
                            <p>{{ __('front/post_types.widgets.newsletter_desc') }}</p>
                            <form action="#" method="get">
                                <input type="email" name="nl-email" id="nlEmail" class="form-control" placeholder="{{ __('front/post_types.widgets.newsletter_email') }}">
                                <button type="submit" class="btn roberto-btn w-100">{{ __('front/post_types.widgets.newsletter_button') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="single-widget-area mb-100">
                        <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.news') }}</h4>
                        @foreach(recentNews(4) as $recent)
                            <div class="single-recent-post d-flex">
                                <div class="post-thumb">
                                    <a href="{{ getNewsLink($recent->slug) }}"><img src="{{ $recent->image }}" alt="{{ $recent->title }}"></a>
                                </div>
                                <div class="post-content">
                                    <div class="post-meta">
                                        <a href="{{ getNewsLink($recent->slug) }}" class="post-author">{{ $recent->created_at->format('Y-m-d') }}</a>
                                        <a href="{{ getCatLink($recent->category->slug) }}" class="post-tutorial">{{ $recent->category->title }}</a>
                                    </div>
                                    <a href="{{ getNewsLink($recent->slug) }}" class="post-title">{{ $recent->title }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="single-widget-area mb-100 clearfix">
                        <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.tags') }}</h4>
                        <ul class="popular-tags">
                            @foreach(recenttags(4) as $tag)
                                <li><a href="#">{{ $tag->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="single-widget-area mb-100 clearfix">
                        <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.images') }}</h4>

                        <ul class="instagram-feeds">
                            @foreach(recentImages(6) as $image)
                                <li><a href="{{ getImageLink($image->slug) }}"><img src="{{ $image->image }}" alt="{{ $image->title }}"></a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="single-widget-area mb-100 clearfix">
                        <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.videos') }}</h4>

                        <ul class="instagram-feeds">
                            @foreach(recentVideos(6) as $video)
                                <li><a href="{{ getVideoLink($video->slug) }}"><img src="{{ $video->image }}" alt="{{ $video->title }}"></a></li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>