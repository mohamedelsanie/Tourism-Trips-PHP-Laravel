
<footer class="footer-area section-padding-80-0">

    <div class="main-footer-area">
        <div class="container">
            <div class="row ">

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget mb-80">

                        <a href="#" class="footer-logo"><img src="{{ getSetting('footer_logo') }}" alt=""></a>
                        <h4>{{ getSetting('phone') }}</h4>
                        <span>{{ getSetting('email') }}</span>
                        <span>{{ getSetting('footer_adress') }}</span>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget mb-80">

                        <h5 class="widget-title">{{ getSetting('footer_blog_title') }}</h5>

                        @if(!empty(latestnews()))
                            @foreach(latestnews() as $item)
                                <div class="latest-blog-area">
                                    <a href="{{ getNewsLink($item->slug) }}" class="post-title">{{ $item->title }}</a>
                                    <span class="post-date"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $item->created_at->format('Y-m-d') }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-12 col-sm-4 col-lg-2">
                    <div class="single-footer-widget mb-80">

                        <h5 class="widget-title">{{ getSetting('footer_menu_title') }}</h5>

                        <ul class="footer-nav">
                            @foreach(getMenu(getSetting('footer_menu')) as $item)
                                @if($item->type == 'post')
                                    <li><a href="{{ getNewsLink($item->slug) }}"><i class="fa fa-caret-{{ __('front/common.right') }}" aria-hidden="true"></i> {{ $item->name }}</a></li>
                                @elseif($item->type == 'category')
                                    <li><a href="{{ getCatLink($item->slug) }}"><i class="fa fa-caret-{{ __('front/common.right') }}" aria-hidden="true"></i> {{ $item->name }}</a></li>
                                @elseif($item->type == 'tour_category')
                                    <li><a href="{{ getTourCatLink($item->slug) }}"><i class="fa fa-caret-{{ __('front/common.right') }}" aria-hidden="true"></i> {{ $item->name }}</a></li>
                                @elseif($item->type == 'tour')
                                    <li><a href="{{ getTourLink($item->slug) }}"><i class="fa fa-caret-{{ __('front/common.right') }}" aria-hidden="true"></i> {{ $item->name }}</a></li>
                                @else
                                    <li><a href="{{ $item->slug }}"><i class="fa fa-caret-{{ __('front/common.right') }}" aria-hidden="true"></i> {{ $item->name }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-sm-8 col-lg-4">
                    <div class="single-footer-widget mb-80">
                        <h5 class="widget-title">{{ getSetting('footer_subscribe_title') }}</h5>
                        <span>{{ getSetting('footer_subscribe_desc') }}</span>
                        <form action="#" class="nl-form">
                            <input type="email" class="form-control" placeholder="Enter your email...">
                            <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="copywrite-content">
            <div class="row align-items-center">
                <div class="col-12 col-md-8">

                    <div class="copywrite-text">
                        <p>
                            {!! __('front/common.copyrights',['link' => '#']) !!}

                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-4">

                    <div class="social-info">
                        <a href="{{ getSetting('facebook') }}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://api.whatsapp.com/send?phone={{ getSetting('phone') }}&amp;text=Hi there! I have a question :)"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="{{ getSetting('twitter') }}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="{{ getSetting('youtube') }}"><i class="fa fa-play" aria-hidden="true"></i></a>
                        <a href="{{ getSetting('instagram') }}"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
