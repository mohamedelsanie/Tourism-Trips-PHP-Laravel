<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ getSetting('site_name') }} - {{ __('admin/common.title_tag') }} @yield('page_title', '')</title>

    <!-- Site favicon -->
    <link rel="icon" href="{{ getSetting('site_favicon') }}" />

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/styles/icon-font.min.css') }}" />
    @if(LaravelLocalization::getCurrentLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/styles/core-rtl.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/styles/rtl.css') }}" />
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/styles/core.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/styles/style.css') }}" />
    @endif
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/src/plugins/dropzone/src/dropzone.css') }}"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="sidebar-light {{ getCookie('body_class') ? getCookie('body_class') : '' }}">

{{--<div class="pre-loader">--}}
    {{--<div class="pre-loader-box">--}}
        {{--<div class="loader-logo">--}}
            {{--<img src="{{ asset('assets/admin/vendors/images/logo.png') }}" alt="" />--}}
        {{--</div>--}}
        {{--<div class="loader-progress" id="progress_div">--}}
            {{--<div class="bar" id="bar1"></div>--}}
        {{--</div>--}}
        {{--<div class="percent" id="percent1">0%</div>--}}
        {{--<div class="loading-text">{{ __('admin/common.loading') }}</div>--}}
    {{--</div>--}}
{{--</div>--}}

@include('admin.partials.header')

@include('admin.partials.sidebar')

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">

            @if (isset($header))
                {{ $header }}
            @endif

            <main>
                @include('admin.partials.flash')
                {{ $slot }}
            </main>
        </div>
        @include('admin.partials.footer')
    </div>
</div>


    <!-- js -->
    <script src="{{ asset('assets/admin/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('assets/admin/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/scripts/dashboard3.js') }}"></script>
    <script src="{{ asset('assets/admin/vendors/scripts/editor.js') }}"></script>

    @livewireScripts
    @yield('scripts')
    <script>
        $(function () {
            $('#alert_session').fadeTo(3000,300).slideUp(300,function () {
                $(this).slideUp(300);
            });

            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);

                $('.destroy_all').toggleClass("hidden"); //you can list several class names
                e.preventDefault();
            });

            $("table input[type=checkbox]").click(function () {
                $('.destroy_all').toggle($('table input[type=checkbox]:checked').length > 0);
                //$('.destroy_all').show(); //you can list several class names
                e.preventDefault();
            });

            $(".date-picker2").datepicker({
                language: "en",
                autoClose: true,
                dateFormat: "dd/mm/yyyy",
                position: 'bottom left',
//                inline: true,
                todayButton: true,
                clearButton: true,
            });

            $(".Menu_Toggle").click(function(){
                $.ajax({
                    type: 'get',
                    context: this,
                    url: '{{ route('admin.sidebar') }}',
                    data: {}, //sidebar:''
                    complete: function(data){
                    }
                });
            });
            tinymce.init({
              selector: 'textarea#editor_ar',
              height: 500,
              plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
              ],
              toolbar: 'undo redo | blocks | ' +
              'bold italic backcolor | alignleft aligncenter ' +
              'alignright alignjustify | bullist numlist outdent indent | ' +
              'removeformat | help',
              content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });
            
            tinymce.init({
              selector: 'textarea#editor_en',
              height: 500,
              plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
              ],
              toolbar: 'undo redo | blocks | ' +
              'bold italic backcolor | alignleft aligncenter ' +
              'alignright alignjustify | bullist numlist outdent indent | ' +
              'removeformat | help',
              content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            });

        });
    </script>
    </body>
</html>
