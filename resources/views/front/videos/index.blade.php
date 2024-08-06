<x-app-layout>
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ asset('assets/front/img/bg-img/17.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ __('front/post_types.videos.title') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">{{ __('front/common.home') }} </a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('front/post_types.videos.title') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="roberto-news-area section-padding-100-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                @if(!empty($posts))
                @foreach($posts as $post)
                    <div class="single-blog-post d-flex align-items-center mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <div class="post-thumbnail">
                            <a href="{{ getVideoLink($post->slug) }}"><img src="{{ $post->image }}" alt="{{ $post->title }}"></a>
                        </div>
                        <div class="post-content">
                            <div class="post-meta">
                                <a href="{{ getVideoLink($post->slug) }}" class="post-author">{{ $post->created_at->format('Y-m-d') }}</a>
                            </div>
                            <a href="{{ getVideoLink($post->slug) }}" class="post-title">{{ $post->title }}</a>
                            <p>{!! Str::words($post->description, 20,'...') !!}</p>
                            <a href="{{ getVideoLink($post->slug) }}" class="btn continue-btn">{{ __('front/post_types.videos.view_post') }}</a>
                        </div>
                    </div>
                    @endforeach
                    <nav class="roberto-pagination wow fadeInUp mb-100" data-wow-delay="600ms">
                        {!! $posts->links() !!}
                    </nav>
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
@section('page_title'){{ __('front/post_types.videos.title') }}@endsection
</x-app-layout>