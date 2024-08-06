<x-app-layout>

    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ $post->image }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ $post->title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{{ __('front/common.home') }} </a></li>
                                <li class="breadcrumb-item"><a href="{{ getTourCatLink($post->category->slug) }}">{{ $post->category->title }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="roberto-rooms-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8">

                    <div class="single-room-details-area mb-50">
                        @if($post->from_place != '' && $post->from_date != '' && $post->to_place != '' && $post->to_date != '')
                        <div class="room-features-area d-flex flex-wrap mb-50">
                            @if($post->from_place != '')<h6>{{ __('front/post_types.tour.from_place') }} : <span>{{ $post->from_place }}</span></h6>@endif
                            @if($post->from_date != '')<h6>{{ __('front/post_types.tour.from_date') }} : <span>{{ $post->from_date }}</span></h6>@endif
                            @if($post->to_place != '')<h6>{{ __('front/post_types.tour.to_place') }} : <span>{{ $post->to_place }}</span></h6>@endif
                            @if($post->to_date != '')<h6>{{ __('front/post_types.tour.to_date') }} : <span>{{ $post->to_date }}</span></h6>@endif
                        </div>
                        @endif
                        <div class="post-thumbnail mb-50">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="tour_thumb">
                        </div>


                        <div class="room-features-area d-flex flex-wrap mb-50">
                            <h6>{{ __('front/post_types.tour.price') }} : </h6>
                            <h6> <span>{{ getPrice($post->price) }}</span></h6>
                            <h6>{{ __('front/post_types.tour.price') }} : </h6>
                            <h6> <span>{{ getEgPrice($post->price_eg).__('front/common.price_eg') }}</span></h6>
                            <h6>{{ __('front/post_types.tour.category') }} : </h6>
                            <h6> <a href="{{ getTourCatLink($post->category->slug) }}"><span>{{ $post->category->title }}</span></a></h6>
                        </div>
                        <p class="desc">{!! $post->description !!}</p>
                        <div class="desc">{!! $post->content !!}</div>
                    </div>

                    <div class="post-author-area d-flex align-items-center justify-content-between mb-50">
                        <div class="author-social-info d-flex align-items-center">
                            <p>{{ __('front/post_types.tour.share') }} :</p>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ getTourLink($post->slug) }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ getTourLink($post->slug) }}&text={{ $post->title }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="https://plus.google.com/share?url={{ getTourLink($post->slug) }}" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                            <a href="{{ getPageLink(getSetting('contact_page')) }}" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <div class="room-review-area mb-100">
                        <h4>{{ __('front/post_types.tour.reviews') }} @if(!empty($comments)) ( {{ count($comments) }} ) @else ( 0 ) @endif</h4>

                        @foreach($comments as $comment)
                            {{-- show the comment markup --}}
                            <div class="single-room-review-area d-flex align-items-center">
                                @include('front.tours.parent-comment', ['comment' => $comment])
                            </div>
                            @if($comment->children->count() > 0)
                                <ol class="children">
                                    {{-- recursively include this view, passing in the new collection of comments to iterate --}}
                                    @include('front.tours.child-comment', ['comments' => $comment->children])
                                </ol>
                            @endif
                        @endforeach

                        <div class="roberto-contact-form mt-80 mb-100" id="addComment">
                            <h2>{{ __('front/post_types.comments.add') }}</h2>
                            <form action="{{ route('tours.add_comment',$post->slug) }}" method="post">
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
                                    <input name="tour_id" type="text" class="hidden" value="{{ $post->id }}" />
                                    <div class="col-12">
                                        <button type="submit" class="btn roberto-btn btn-3 mt-15">{{ __('front/post_types.comments.post') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">

                    <div class="hotel-reservation--area mb-100">

                        <div class="col-md-12">

                            @if(!empty($offers))
                                <div class="shopping-cart">
                                <!-- Title -->
                                    <div class="title"><h3>{{ __('front/post_types.tour.offers') }}</h3> <h4>{{ __('front/post_types.tour.offers_desc') }}</h4></div>
                                    @foreach($offers as $offer)
                                        <!-- Product #1 -->
                                        <div class="item">
                                            <div class="image">
                                                <img src="{{ $offer->offers->image }}" alt="{{ $offer->offers->title }}" />
                                            </div>
                                            <div class="description">
                                                <span>{{ $offer->offers->title }}</span>
                                            </div>
                                            <div class="buttons">
                                                <a class="btn delete-btn addButton"  data-id="{{ $offer->offers->id }}">{{ __('front/post_types.tour.add_offer') }}</a>
                                                <div class="total-price" data-price="{{ $offer->offers->price }}">{{ getPrice($offer->offers->price) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="title_down">
                                        <p>{{ __('front/post_types.tour.total_price') }} <span class="totalPrice">{{ $post->price }}</span> {{ getSetting('currency') }}</p>
                                        @auth
                                        <div id="checkOut" class="checkout_box">
                                        <form action="{{ route('payment.pay') }}" method="POST">
                                            @csrf
                                            <input type="hidden" class="totalprice" name="totalprice" value="{{ $post->price }}" />
                                            <input type="hidden" name="tour" value="{{ $post->id }}" />
                                            <input type="hidden" name="user" value="{{ Auth::user()->id }}" />
                                            <button type="submit" class="btn btn-primary">{{ __('front/post_types.tour.checkout') }}</button>
                                        </form>
                                        </div>
                                        @else
                                        <a data-toggle="modal" href="#checkOut" class="btn btn-primary">{{ __('front/post_types.tour.checkout') }}</a>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            </div>

                        </div>
                    @auth
                    @else
                    <!-- Modal -->
                    <div class="modal fade" id="checkOut" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('payment.pay') }}" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                    <h4 class="modal-title">{{ __('front/post_types.tour.checkout') }}</h4>
                                </div>
                                <div class="modal-body">
                                    @csrf

                                    @livewire('login-register',['page'=>request()->fullUrl()])
                                    <input type="hidden" class="totalprice" name="totalprice" value="{{ $post->price }}" />
                                    <input type="hidden" name="tour" value="{{ $post->id }}" />
                                </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>

    <section class="roberto-cta-area">
        <div class="container">
            <div class="cta-content bg-img bg-overlay jarallax" style="background-image: url({{ asset('assets/front/img/bg-img/1.jpg') }});">
                <div class="row align-items-center">
                    <div class="col-12 col-md-7">
                        <div class="cta-text mb-50">
                            <h2>{{ getSetting('contact_title') }}</h2>
                            <h6>{{ getSetting('contact_desc') }}</h6>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 text-right">
                        <a href="{{ getPageLink(getSetting('contact_page')) }}" class="btn roberto-btn mb-50">{{ __('front/common.contact') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br />
    <br />
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                /******************/
                var buttonclicked;
                $(".comment-meta .reply").click(function () {
                    if( buttonclicked!= true ) {
                        buttonclicked= true;
                        var commentId = $(this).data('id');
                        var input = $('<input type="text" class="hidden" name="parent" value="'+commentId+'" />');
                        $(".roberto-contact-form form").append(input);
                    }else{
                        $(".roberto-contact-form form input[name='parent']").remove();
                        buttonclicked= false;
                    }
                });

                $(".rate-area label").click(function () {
                    $('html, body').stop().animate({
                        'scrollTop': $('.roberto-contact-form form').offset().top
                    }, 900, 'swing', function () {
                    });

                });
                $('a[href^="#"]').on('click',function (e) {
                    e.preventDefault();
                    var target = this.hash;
                    var $target = $(target);
                    $('html, body').stop().animate({
                        'scrollTop': $target.offset().top
                    }, 900, 'swing', function () {
                        // window.location.hash = target;
                    });
                });

                $('.addButton').on('click', function() {
                    $(this).toggleClass('is-active');
                    $(this).text(($(this).text() == "{{ __('front/post_types.tour.add_offer') }}") ? "{{ __('front/post_types.tour.added_offer') }}" : "{{ __('front/post_types.tour.add_offer') }}").fadeIn();
                    //alert($(this).parent().children('.total-price').data('price'));
                    var standerd = parseInt($('.totalPrice').text());
                    var offer = parseInt($(this).parent().children('.total-price').data('price'));
                    if($(this).hasClass('is-active')){
                        $('.totalPrice').text(standerd+offer);
                        $("#checkOut form .totalprice").val(standerd+offer);
                        var offerId = $(this).parent().children('.addButton').data('id');
                        var input = $('<input type="hidden" class="offer'+offerId+'" name="offer[]" value="'+offerId+'" />');
                        $("#checkOut form").append(input);
                    }else{
                        $('.totalPrice').text(standerd-offer);
                        $("#checkOut form .totalprice").val(standerd-offer);
                        var offerId = $(this).parent().children('.addButton').data('id');
                        $('#checkOut form .offer'+offerId+'').remove();
                    }
                    //$(this).parent().children('.total-price').data('price')+$('.totalPrice').text()

                });
                /******************/
            });
        </script>
    @endsection

    @section('page_title'){{ __('front/post_types.tours.title') }} - {{ $post->title }}@endsection
</x-app-layout>