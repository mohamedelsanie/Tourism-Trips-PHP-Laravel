<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ getSetting('site_meta_description') }}">
    <meta name="keywords" content="{{ getSetting('site_meta_keywords') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ getSetting('site_name') }} - @yield('page_title', '')</title>

    <link rel="icon" href="{{ getSetting('site_favicon') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(LaravelLocalization::getCurrentLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('assets/front/rtl.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/front/style.css') }}">
    @endif
    @yield('styles')
    @livewireStyles
<body>

{{--<div id="preloader">--}}
    {{--<div class="loader"></div>--}}
{{--</div>--}}
    <div class="Notificate">
        @if(getSetting('site_status') == 'closed')
        <div class="siteClosed">
            <div class="container">
                <h3>{{ __('front/common.notification') }}</h3><p>{{ __('front/common.notification_closed') }}</p>
            </div>
        </div>
        @endif
        @if(auth()->guard('admin')->user())
            <div class="adminBar">
                <div class="container">
                    <nav class="admin-nav-bar">
                        <p>{{ __('front/common.notification_logas').' '.auth()->guard('admin')->user()->name.' ' }}</p>
                        <a href="{{ route('admin.dashboard') }}">{{ __('front/common.dashboard') }}</a>
                    </nav>
                </div>
            </div>
        @endif
    </div>
    @include('front.partials.header')

    @include('front.partials.flash')
    {{ $slot }}

    @include('front.partials.footer')

    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/front/js/roberto.bundle.js') }}"></script>

    @if(LaravelLocalization::getCurrentLocale() == 'ar')
    <script src="{{ asset('assets/front/js/default-assets/active-ar.js') }}"></script>
    @else
    <script src="{{ asset('assets/front/js/default-assets/active.js') }}"></script>
    @endif
    <script type="text/javascript">
        $(document).ready(function() {

            /******************/
            setTimeout(function(){
                $('.alert').removeClass("show");
                $('.alert').addClass("hide");
            },5000);
            $('.alert .close-btn').click(function () {
                $('.alert').removeClass("show");
                $('.alert').addClass("hide");
            });
            /******************/
        });
    </script>
    @yield('scripts')
    @livewireScripts
    {!! getSetting('tawk_code') !!}
    </body>
</html>
