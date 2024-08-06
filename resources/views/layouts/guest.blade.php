<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="{{ getSetting('site_meta_description') }}">
        <meta name="keywords" content="{{ getSetting('site_meta_keywords') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ getSetting('site_name') }} - @yield('page_title', '')</title>

        <link rel="icon" href="{{ getSetting('site_favicon') }}">
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
            <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-rtl.min.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/front/css/login-ar.css') }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/front/css/login.css') }}">
        @endif
        <link rel="stylesheet" href="{{ asset('assets/front/css/font-awesome.min.css') }}">
        @yield('styles')
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
        @yield('scripts')
    </body>
</html>
