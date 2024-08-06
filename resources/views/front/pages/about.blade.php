
<section class="roberto-about-us-area section-padding-100-0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-6">
                <div class="about-thumbnail pr-lg-5 mb-100 wow fadeInUp" data-wow-delay="100ms">
                    <img src="{{ getSetting('about_sec1_img') }}" alt="{{ getSetting('about_sec1_title') }}">
                </div>
            </div>
            <div class="col-12 col-lg-6">

                <div class="section-heading wow fadeInUp" data-wow-delay="300ms">
                    <h6>{{ getSetting('about_sec1_title') }}</h6>
                    <h2>{{ getSetting('about_sec1_desc') }}</h2>
                </div>
                <div class="about-content mb-100 wow fadeInUp" data-wow-delay="500ms">
                    <p>{{ getSetting('about_sec1_data') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="roberto--video--area bg-img bg-overlay jarallax section-padding-0-100" style="background-image: url({{ asset('assets/front/img/bg-img/20.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-md-6">

                <div class="section-heading text-center white wow fadeInUp" data-wow-delay="100ms">
                    <h6>{{ getSetting('about_sec2_title') }}</h6>
                    <h2>{{ getSetting('about_sec2_desc') }}</h2>
                </div>
                <div class="video-content-area mt-100 wow fadeInUp" data-wow-delay="500ms">
                    <a href="{{ getSetting('about_sec2_link') }}" class="video-play-btn"><i class="fa fa-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="roberto-service-area section-padding-100-0">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms">
                    <h6>{{ getSetting('about_sec3_title') }}</h6>
                    <h2>{{ getSetting('about_sec3_desc') }}</h2>
                </div>
            </div>
        </div>
        @php
            $sliders = json_decode(getSetting('about_sec3'), true);
            $slides = array_values($sliders);
        @endphp
        @if(!empty($slides))
            @if(is_array($slides))
                <div class="row">
                    @php $ii = 0; @endphp
                    @for($i = 0; $i < count($slides[0]); $i++)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="single-service-area mb-100 wow fadeInUp" data-wow-delay="300ms">
                                <img src="{{ $slides[1][$i] }}" alt="">
                                <div class="service-title d-flex align-items-center justify-content-center">
                                    <h5>{{ $slides[0][$i] }}</h5>
                                </div>
                            </div>
                        </div>
                        @php $ii++; @endphp
                    @endfor
                </div>
            @endif
        @endif
    </div>
</section>