<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>{{ __('admin/common.dashboard') }}</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/common.dashboard') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="card-box pd-20 height-100-p mb-30">
    <div class="row align-items-center">
        <div class="col-md-4">
            <img src="{{ asset('assets/admin/vendors/images/banner-img.png') }}" alt="" />
        </div>
        <div class="col-md-8">
            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                <b>{{ __('admin/common.messages.admin_hello') }}</b>
                <div class="weight-600 font-30 text-blue">{{ Auth::guard('admin')->user()->name }}</div>
            </h4>
            <p class="font-18 max-width-600">
                {{ __('admin/common.messages.admin_hello_msg') }}
            </p>
        </div>
    </div>
    </div>

    <div class="row pb-10">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $news }}</div>
                        <div class="font-14 text-secondary weight-500">
                            {{ __('admin/common.blocks.news') }}
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-calendar1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $tours }}</div>
                        <div class="font-14 text-secondary weight-500">
                            {{ __('admin/common.blocks.tours') }}
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#ff5b5b">
                            <span class="icon-copy ti-heart"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $orders }}</div>
                        <div class="font-14 text-secondary weight-500">
                            {{ __('admin/common.blocks.orders') }}
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i
                                    class="icon-copy fa fa-stethoscope"
                                    aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $contacts }}</div>
                        <div class="font-14 text-secondary weight-500">{{ __('admin/common.blocks.contacts') }}</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#09cc06">
                            <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="title pb-20 pt-20">
        <h2 class="h3 mb-0">{{ __('admin/common.blocks.title') }}</h2>
    </div>

    <div class="row">
        <div class="col-md-4 mb-20">
            <a href="{{ route('admin.posts.index') }}" class="card-box d-block mx-auto pd-20 text-secondary">
                <div class="img pb-30">
                    <img src="{{ asset('assets/admin/vendors/images/news.png') }}" alt="" />

                </div>
                <div class="content">
                    <h3 class="h4 text-center">{{ __('admin/common.blocks.news_title') }}</h3>
                    <p class="text-center">
                        {{ __('admin/common.blocks.news_desc') }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-20">
            <a href="{{ route('admin.tours.index') }}" class="card-box d-block mx-auto pd-20 text-secondary">
                <div class="img pb-30">
                    <img src="{{ asset('assets/admin/vendors/images/tours.png') }}" alt="" />
                </div>
                <div class="content">
                    <h3 class="h4 text-center">{{ __('admin/common.blocks.tours_title') }}</h3>
                    <p class="text-center">
                        {{ __('admin/common.blocks.tours_desc') }}
                    </p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-20">
            <a href="{{ route('admin.pages.index') }}" class="card-box d-block mx-auto pd-20 text-secondary">
                <div class="img pb-30">
                    <img src="{{ asset('assets/admin/vendors/images/pages.png') }}" alt="" />
                </div>
                <div class="content">
                    <h3 class="h4 text-center">{{ __('admin/common.blocks.pages_title') }}</h3>
                    <p class="text-center">
                        {{ __('admin/common.blocks.pages_desc') }}
                    </p>
                </div>
            </a>
        </div>
    </div>

    @section('page_title'){{ __('admin/common.title_home') }}@endsection
</x-admin-layout>

