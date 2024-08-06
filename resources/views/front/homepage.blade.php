<x-app-layout>
    @if(getSetting('slider_st') == 'enabled')
    <section class="welcome-area">
        <div class="welcome-slides owl-carousel">
            @php
                $sliders = json_decode(getSetting('slider'), true);
                $slides = array_values($sliders);
            @endphp
            @if(!empty($slides))
                @if(is_array($slides))
                    @php $ii = 0; @endphp
                    @for($i = 0; $i < count($slides[0]); $i++)
                        <div class="single-welcome-slide bg-img bg-overlay" style="background-image: url({{ $slides[2][$i] }});" data-img-url="{{ $slides[2][$i] }}">
                            <div class="welcome-content h-100">
                                <div class="container h-100">
                                    <div class="row h-100 align-items-center">

                                        <div class="col-12">
                                            <div class="welcome-text text-center">
                                                <h6 data-animation="fadeInLeft" data-delay="200ms">{{ $slides[0][$i] }}</h6>
                                                <h2 data-animation="fadeInLeft" data-delay="500ms">{{ $slides[1][$i] }}</h2>
                                                <a href="{{ $slides[3][$i] }}" class="btn roberto-btn btn-2" data-animation="fadeInLeft" data-delay="800ms">{{ $slides[4][$i] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @php $ii++; @endphp
                    @endfor
                @endif
            @endif
        </div>
    </section>
    @endif

    <section class="roberto-about-area @if(getSetting('search_st') == 'enabled') section-padding-100-0 @endif">
        @if(getSetting('search_st') == 'enabled')
        <div class="hotel-search-form-area">
            <div class="container-fluid">
                <div class="hotel-search-form">
                    <form action="{{ route('tours.search') }}" method="post">
                                @csrf
                        <div class="row justify-content-between align-items-end">
                            <div class="col-6 col-md-3 col-lg-3">
                                <label for="checkIn">{{ __('front/post_types.widgets.from_date') }}</label>
                                <input type="text" class="date-picker2 form-control" id="checkIn0" name="from_date" placeholder="{{ __('front/post_types.widgets.from_date') }}">
                            </div>
                            <div class="col-6 col-md-3 col-lg-3">
                                <label for="checkOut">{{ __('front/post_types.widgets.to_date') }}</label>
                                <input type="text" class="date-picker2 form-control" id="checkOut0" name="to_date" placeholder="{{ __('front/post_types.widgets.to_date') }}">
                            </div>

                            <div class="col-4 col-md-2">
                                <label for="room">{{ __('front/post_types.widgets.from_place') }}</label>
                                <input type="text" name="from_place" value="{{ old('from_place') }}" class="input-small form-control" id="checkInPlace" placeholder="{{ __('front/post_types.widgets.from_place') }}">
                            </div>

                            <div class="col-4 col-md-2">
                                <label for="room">{{ __('front/post_types.widgets.to_place') }}</label>
                                <input type="text" name="to_place" value="{{ old('to_place') }}" class="input-small form-control" placeholder="{{ __('front/post_types.widgets.to_place') }}">
                            </div>

                            <div class="col-12 col-md-2">
                                <button type="submit" class="form-control btn roberto-btn w-100">{{ __('front/post_types.widgets.search_button') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <div class="container mt-100">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">

                    <div class="section-heading wow fadeInUp" data-wow-delay="100ms">
                        <h6>{{ getSetting('about_title') }}</h6>
                        <h2>{{ getSetting('about_desc') }}</h2>
                    </div>
                    <div class="about-us-content mb-100">
                        <h5 class="wow fadeInUp" data-wow-delay="300ms" id="readmore">
                            <span class="readmore__content">
                            {{ getSetting('about_content') }}
                            </span>
                            <button class="readmore__toggle" role="switch" aria-checked="true">
                                {{ __('front/common.showmore') }}
                            </button>
                            </h5>
                        <p class="wow fadeInUp" data-wow-delay="400ms">{{ __('front/common.admins') }} : <span>{{ getSetting('about_admin') }}</span></p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="about-us-thumbnail mb-100 wow fadeInUp" data-wow-delay="700ms">
                        <div class="row no-gutters">
                            <div class="col-6">
                                <div class="single-thumb">
                                    <img src="{{ getSetting('about_img1') }}" alt="">
                                </div>
                                <div class="single-thumb">
                                    <img src="{{ getSetting('about_img2') }}" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="single-thumb">
                                    <img src="{{ getSetting('about_img3') }}" alt="">
                                </div>
                                <div class="single-thumb">
                                    <img src="{{ getSetting('about_img4') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="roberto-service-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="service-content d-flex align-items-center justify-content-between">
                        @php
                            $about_blocks = json_decode(getSetting('about_blocks'), true);
                            $blocks = array_values($about_blocks);
                        @endphp
                        @if(!empty($blocks))
                            @if(is_array($blocks))
                                @php $ii = 0; @endphp
                                @for($i = 0; $i < count($blocks[0]); $i++)
                                    <div class="single-service--area mb-100 wow fadeInUp" data-wow-delay="100ms">
                                        <img src="{{ $blocks[1][$i] }}" alt="">
                                        <h5>{{ $blocks[0][$i] }}</h5>
                                    </div>
                                    @php $ii++; @endphp
                                @endfor
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="roberto-rooms-area add_sec section-padding-100-0">
        <div class="container">
            <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms" style="visibility: visible; animation-delay: 100ms; animation-name: fadeInUp;">
                <h6>{{ getSetting('tours_title') }}</h6>
                <h2>{{ getSetting('tours_desc') }}</h2>
            </div>
            <div class="row">
                @if(!empty($tours))
                    @foreach($tours as $post)
                        <div class="col-12 col-lg-4 col-md-6 col-xs-12">
                            <div class="single-room-area align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                                <div class="room-thumbnail">
                                    <img src="{{ $post->image }}" alt="{{ $post->title }}">
                                </div>
                                <div class="room-content">
                                    <h2>{{ $post->title }}</h2>
                                    <div class="room-feature">
                                        <h6>{!! Str::words($post->description, 16,'...') !!}</h6>
                                    </div>
                                    <div class="mt-10">
                                        <h4>{{ getPrice($post->price) }} </h4>
                                        <br />
                                        <h4>{{ getEgPrice($post->price_eg) }} {{ __('front/common.price_eg') }}</h4>
                                        <a href="{{ getTourLink($post->slug) }}" class="btn roberto-btn">{{ __('front/common.book_tour') }} <i class="fa fa-long-arrow-{{ __('front/common.right') }}" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div style="clear:both"></div>
                <div class="text-center col-12" style="margin: 0 auto;">
                    <a href="{{ route('tours') }}" class="btn roberto-btn2 mb-60">{{ __('front/common.more_tours') }}</a>
                </div>
            </div>
        </div>
    </div>





    <section class="roberto-project-area mt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms">
                        <h2 class="color_title">{{ __('front/common.photos_gallery') }}</h2>
                        <h6 class="nocolor_title">{{ __('front/common.photos_gallery_desc') }}</h6>
                    </div>
                </div>
            </div>
        <div class="row">
        <div class="projects-slides owl-carousel">
            @if(!empty($images))
                @foreach($images as $key => $image)
                    <div class="single-project-slide bg-img @if($key == 1) active @endif" style="background-image: url({{ $image->image }});">
                        <div class="project-content">
                            <div class="text">
                                <h6>{{ $image->title }}</h6>
                            </div>
                        </div>
                        <div class="hover-effects">
                            <div class="text">
                                <h6>{{ $image->title }}</h6>
                                <p>{!! Str::words($image->description, 20,'...') !!}</p>
                            </div>
                            <a href="{{ getImageLink($image->slug) }}" class="btn project-btn">{{ __('front/common.photo_details') }} <i class="fa fa-long-arrow-{{ __('front/common.right') }}" aria-hidden="true"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div style="clear:both"></div>
        <div class="text-center col-12" style="margin: 0 auto;">
            <a href="{{ route('photos') }}" class="btn roberto-btn2 mb-20 mt-40">{{ __('front/common.more_tours') }}</a>
        </div>
        
        </div>
        </div>
    </section>


    <section class="roberto-blog-area section-padding-100-0">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms">
                        <h6>{{ getSetting('news_title') }}</h6>
                        <h2>{{ getSetting('news_desc') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(!empty($news))
                    @foreach($news as $item)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="single-post-area mb-100 wow fadeInUp" data-wow-delay="300ms">
                                <a href="{{ getNewsLink($item->slug) }}" class="post-thumbnail"><img src="{{ $item->image }}" alt="{{ $item->title }}"></a>
                                <div class="post-meta">
                                    <a href="{{ getNewsLink($item->slug) }}" class="post-date">{{ $item->created_at->format('Y-m-d') }}</a>
                                    <a href="{{ getCatLink($item->category->slug) }}" class="post-catagory">{{ $item->category->title }}</a>
                                </div>
                                <a href="#" class="post-title">{{ $item->title }}</a>
                                <p>{!! Str::words($item->description, 20,'...') !!}</p>
                                <a href="{{ getNewsLink($item->slug) }}" class="btn continue-btn">{{ __('front/common.news_more') }} <i class="fa fa-long-arrow-{{ __('front/common.right') }}" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div style="clear:both"></div>
                <div class="text-center col-12" style="margin: 0 auto;">
                    <a href="{{ route('news') }}" class="btn roberto-btn2 mb-60">{{ __('front/common.more_tours') }}</a>
                </div>
            </div>
        </div>
    </section>


    <section class="roberto-project-area mt-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms">
                        <h2 class="color_title">{{ __('front/common.videos_gallery') }}</h2>
                        <h6 class="nocolor_title">{{ __('front/common.videos_gallery_desc') }}</h6>
                    </div>
                </div>
            </div>
        <div class="row">
        <div class="projects-slides owl-carousel">
            @if(!empty($videos))
                @foreach($videos as $key => $video)
                    <div class="single-project-slide bg-img @if($key == 1) active @endif" style="background-image: url({{ $video->image }});">
                        <div class="project-content">
                            <div class="text">
                                <h6>{{ $video->title }}</h6>
                            </div>
                        </div>
                        <div class="hover-effects">
                            <div class="text">
                                <h6>{{ $video->title }}</h6>
                                <p>{!! Str::words($video->description, 20,'...') !!}</p>
                            </div>
                            <a href="{{ getVideoLink($video->slug) }}" class="btn project-btn">{{ __('front/common.video_details') }} <i class="fa fa-long-arrow-{{ __('front/common.right') }}" aria-hidden="true"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div style="clear:both"></div>
        <div class="text-center col-12" style="margin: 0 auto;">
            <a href="{{ route('videos') }}" class="btn roberto-btn2 mb-20 mt-40">{{ __('front/common.more_tours') }}</a>
        </div>
        
        </div>
        </div>
    </section>


    <section class="roberto-testimonials-area mt-40">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-12">
                    <div class="section-heading">
                        <h6>{{ getSetting('testimonials_title') }}</h6>
                        <h2>{{ getSetting('testimonials_desc') }}</h2>
                    </div>
                    <div class="testimonial-slides owl-carousel testi mb-100">
                        @if(!empty($testimonials))
                            @foreach($testimonials as $testimonial)
                                <div class="row single-testimonial-slide">
                                    <div class="col-12 col-md-4 col-sm-4">
                                        <div class="testimonial-thumbnail mb-20">
                                            <img src="{{ asset('assets/front/img/core-img/avater2.jpg') }}" alt="{{ $testimonial->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 col-sm-8">
                                        <h5>“{{ $testimonial->comment }}”</h5>
                                        <div class="rating-title">
                                            <div class="rating">
                                                @if($testimonial->comment_stars == 1)  <i class="icon_star"></i> @endif
                                                @if($testimonial->comment_stars == 2)  <i class="icon_star"></i><i class="icon_star"></i> @endif
                                                @if($testimonial->comment_stars == 3)  <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i> @endif
                                                @if($testimonial->comment_stars == 4)  <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i> @endif
                                                @if($testimonial->comment_stars == 5)  <i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i><i class="icon_star"></i> @endif
                                            </div>
                                            <h6>{{ $testimonial->name }} <span> - {{ __('front/common.customer') }}</span></h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

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



    <div class="partner-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="partner-logo-content d-flex align-items-center justify-content-between wow fadeInUp" data-wow-delay="300ms">

                        {{--<script src='http://netweather.accuweather.com/adcbin/netweather_v2/netweatherV2ex.asp?partner=netweather&tStyle=normal&logo=1&zipcode=AFR|EG|EG011|CAIRO|&lang=uke&size=8&theme=clouds&metric=1&target=_self'></script>--}}
                        {{--<script src="http://www.jscache.com/wejs?wtype=rated&amp;uniq=287&amp;locationId=2346327&amp;lang=en_US"></script>--}}
                        {{--<script src="http://www.jscache.com/wejs?wtype=excellent&amp;uniq=619&amp;locationId=2346327&amp;lang=en_US"></script>--}}
                        {{--<!-- Trip Advisor -->--}}
                        {{--<div id="TA_rated287" class="TA_rated">--}}
                            {{--<ul id="z6jOIlgW5H" class="TA_links 1AcSLvcf">--}}
                                {{--<li id="VhRJ3magf3vF" class="7RZuvr7CN5P">--}}
                                    {{--<a href={{ getSetting('tripadvisor_page') }}>Habibitours - Day Tours</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}

                        {{--<div id="TA_excellent619" class="TA_excellent">--}}
                            {{--<ul id="wcLwzrcB" class="TA_links 3XKK5w">--}}
                                {{--<li id="vA8zIy" class="gfvAF1">--}}
                                    {{--<a target="_blank" href={{ getSetting('tripadvisor_page') }}>Habibitours - Day Tours</a> rated "excellent" by travelers--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        <a href="{{ getSetting('tripadvisor_page') }}" target="_blank"><img src="http://www.habibitours.com/_images/realadv.png" width="160" height="109"></a>
                        <a href="{{ getSetting('realadventures_page') }}"><img alt="" src="https://d3rr2gvhjw0wwy.cloudfront.net/uploads/mandators/25028/file-manager/egypt-top-rated-tour-company.png" style="width: 185px; height: 150px;"></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                
                    $('.date-picker2').datepicker({
                        language: "en",
                        autoclose: true,
                        format: "dd/mm/yyyy"
                    });
                    
                class readMore {
    constructor() {
        this.content = '.readmore__content';
        this.buttonToggle = '.readmore__toggle';
    }

    bootstrap() {
        this.setNodes();
        this.init();
        this.addEventListeners();
    }

    setNodes() {
        this.nodes = {
            contentToggle: document.querySelector(this.content)
        };

        this.buttonToggle = this.nodes.contentToggle.parentElement.querySelector(this.buttonToggle);
    }

    init() {
        const { contentToggle } = this.nodes;

        this.stateContent = contentToggle.innerHTML;

        contentToggle.innerHTML = `${this.stateContent.substring(0, 500)}...`;
    }

    addEventListeners() {
        this.buttonToggle.addEventListener('click', this.onClick.bind(this))
    }

    onClick(event) {
        const targetEvent = event.currentTarget;
        const { contentToggle } = this.nodes

        if (targetEvent.getAttribute('aria-checked') === 'true') {
            targetEvent.setAttribute('aria-checked', 'false')
            contentToggle.innerHTML = this.stateContent;
            this.buttonToggle.innerHTML = '{{ __('front/common.showless') }}'

        } else {
            targetEvent.setAttribute('aria-checked', 'true')
            contentToggle.innerHTML = `${this.stateContent.substring(0, 500)}...`
            this.buttonToggle.innerHTML = '{{ __('front/common.showmore') }}'
        }
    }
}


const initReadMore = new readMore();
initReadMore.bootstrap()
            });
        </script>
    @endsection
    
    
    @section('page_title'){{ __('front/common.title_tag') }}@endsection
</x-app-layout>