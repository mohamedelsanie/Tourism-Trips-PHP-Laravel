<x-app-layout>
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ asset('assets/front/img/bg-img/17.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ __('front/post_types.tours.title') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{{ __('front/common.home') }} </a></li>
                                <li class="breadcrumb-item"><a href="{{ route('tours') }}">{{ __('front/post_types.tours.title') }} </a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="roberto-rooms-area section-padding-100-0 add_sec no-bg">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="row">

                        @if(!empty($posts))
                            @foreach($posts as $post)
                                <div class="col-12 col-lg-6 col-md-6 col-xs-12">
                                    <div class="single-room-area align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                                        <div class="room-thumbnail">
                                            <a href="{{ getTourLink($post->slug) }}"><img src="{{ $post->image }}" alt="{{ $post->title }}"></a>
                                        </div>
                                        <div class="room-content">
                                            <a href="{{ getTourLink($post->slug) }}"><h2>{{ $post->title }}</h2></a>
                                            <div class="room-feature">
                                                <h6>{!! Str::words($post->description, 20,'...') !!}</h6>
                                            </div>
                                            <div class="mt-10">
                                                <h4>{{ getPrice($post->price) }} </h4>
                                        <br />
                                        <h4>{{ getEgPrice($post->price_eg) }} {{ __('front/common.price_eg') }}</h4>
                                                <a href="{{ getTourLink($post->slug) }}" class="btn roberto-btn">{{ __('front/post_types.tours.view_post') }} <i class="fa fa-long-arrow-{{ __('front/common.right') }}" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <nav class="roberto-pagination wow fadeInUp mb-100" data-wow-delay="600ms">
                                {!! $posts->links() !!}
                            </nav>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-4">

                    <div class="roberto-sidebar-area pl-md-4">
                        <div class="hotel-reservation--area single-widget-area mb-100">
                            <h4 class="widget-title mb-30">{{ __('front/post_types.widgets.search') }}</h4>
                            <form action="{{ route('tours.search') }}" method="post">
                                @csrf
                                <div class="form-group mb-30">
                                    <label for="checkInDate">{{ __('front/post_types.widgets.search_date') }}</label>
                                    <div class="input-group">
                                        <div class="row no-">
                                            <div class="col-6">
                                                <input type="text" name="from_date" value="{{ old('from_date') }}" class="date-picker2 input-small form-control" id="checkInDate" placeholder="Check In">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="to_date" value="{{ old('to_date') }}" class="date-picker2 input-small form-control" id="checkOutDate" placeholder="Check Out">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-30">
                                    <label for="checkInPlace">{{ __('front/post_types.widgets.search_place') }}</label>
                                    <div class="input-">
                                        <div class="row no-">
                                            <div class="col-6">
                                                <input type="text" name="from_place" value="{{ old('from_place') }}" class="input-small form-control" id="checkInPlace" placeholder="From Place">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="to_place" value="{{ old('to_place') }}" class="input-small form-control" placeholder="To Place">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-50">
                                    <div id="range-slider">
                                        <label>{{ __('front/post_types.widgets.search_price') }}</label>
                                        <div id="slider-range"></div>
                                        <p>
                                            <input type="text" name="amount" id="amount" readonly style="border:0;">
                                        </p>
                                    </div> <!-- close range-slider div -->
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn roberto-btn w-100">{{ __('front/post_types.widgets.search_button') }}</button>
                                </div>
                            </form>
                        </div>
                        <br>
                        <br>

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

                        <div class="single-widget-area mb-100 clearfix" style="margin-top: 40px;">
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

                $( function() {
                    $('.date-picker2').datepicker({
                        language: "en",
                        autoclose: true,
                        format: "dd/mm/yyyy"
                    });
                    $( "#slider-range" ).slider({
                        range: true,
                        min: 0,
                        max: 10000,
                        step: 100,
                        values: [ 0, 10000 ],
                        slide: function( event, ui ) {
                            $( "#amount" ).val( ui.values[ 0 ] + "-" + ui.values[ 1 ] );
                        }
                    });
                    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) + "-" + $( "#slider-range" ).slider( "values", 1 ) );
                } );

            });
        </script>
    @endsection
    @section('page_title'){{ __('front/post_types.tours.title') }} - {{ $category->title }}@endsection
</x-app-layout>