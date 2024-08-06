
<header class="header-area">


    <div class="top-header-area">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="top-header-content">
                        <a href="#"><i class="icon_phone"></i> <span>{{ getSetting('phone') }}</span></a>
                        <a href="#"><i class="icon_mail"></i> <span><span class="">{{ getSetting('email') }}</span></span></a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="top-header-content">

                        <div class="top-social-area ml-auto">
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
    </div>

    <div class="main-header-area">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">

                <nav class="classy-navbar justify-content-between" id="robertoNav">

                    <a class="nav-brand" href="{{ getSetting('site_url') }}"><img src="{{ getSetting('site_logo') }}" alt="" style="width: 180px;"></a>

                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>

                    <div class="classy-menu">

                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <li class="classynav">
                            <ul id="nav">
                                    <li class="{{ activeMenu('ar','en') }}"><a href="{{ getSetting('site_url') }}">{{ __('front/common.home') }}</a></li>
                                @foreach(getMenu(getSetting('header_menu')) as $item)
                                    
                                    <li><a href="{{ $item->link }}">{{ $item->name }}</a>
                                        @if(!empty($item->children))
                                            <ul class="dropdown">
                                                @foreach($item->children as $child)
                                                    @foreach($child as $ch)
                                                        <li><a href="{{ $ch->link }}">{{ $ch->name }}</a></li>
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>

                                @endforeach
                                @if(getSetting('langs_menu_st') == 'enabled')
                                <li><a>{{ LaravelLocalization::getCurrentLocaleNative() }}</a>
                                    <ul class="dropdown">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li><a hreflang="{{ $localeCode }}"
                                               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                {{ $properties['native'] }}
                                            </a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endif
                                @if(getSetting('login_menu_st') == 'enabled')
                                @auth
                                <li><a>{{ Auth::user()->name }}</a>
                                    <ul class="dropdown">
                                        <li><a href="{{ route('profile.edit') }}">{{ __('front/common.profile') }}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{ __('front/common.orders') }}</a></li>
                                        <li><form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">{{ __('front/common.logout') }}</a>
                                        </form></li>
                                    </ul>
                                </li>
                                @else
                                    <li>
                                        <a href="{{ route('login') }}">{{ __('front/common.login') }}</a>
                                    </li>
                                @endif
                                @endif
                            </ul>
                        </li>
                        @if(getSetting('book_menu_st') == 'enabled')
                        <div class="book-now-btn btn-book ml-3 ml-lg-5">
                            <a href="{{ getSetting('book_page') }}">{!! __('front/common.book_now') !!} </a>
                        </div>
                        @endif
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>

