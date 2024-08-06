
<section class="roberto-about-us-area section-padding-100-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-12">
                <div class="about-content mb-100 wow fadeInUp" data-wow-delay="100ms">
                    <p>{!! $page->content !!}</p>
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
            </div>
        </div>
    </div>
</section>