<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/setting.title') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </x-slot>
    @php
        $field1 = 'site_logo';
        $field2 = 'site_favicon';
        $field3 = 'about_img1';
        $field4 = 'about_img2';
        $field5 = 'about_img3';
        $field6 = 'about_img4';
        $field7 = 'footer_logo';
        $field8 = 'image8';
    @endphp
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/setting.title') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.settings.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf

                    <!-- Demo header-->

                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- Tabs nav -->
                                        <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <a class="nav-link mb-3 p-3 shadow active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                                <i class="fa fa-user-circle-o mr-2"></i>
                                                <span class="font-weight-bold small text-uppercase">{{ __('admin/setting.genral_settings') }}</span></a>

                                            <a class="nav-link mb-3 p-3 shadow" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                                <i class="fa fa-calendar-minus-o mr-2"></i>
                                                <span class="font-weight-bold small text-uppercase">{{ __('admin/setting.header_settings') }}</span></a>

                                            <a class="nav-link mb-3 p-3 shadow" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                                                <i class="fa fa-star mr-2"></i>
                                                <span class="font-weight-bold small text-uppercase">{{ __('admin/setting.home_settings') }}</span></a>

                                            <a class="nav-link mb-3 p-3 shadow" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                                <i class="fa fa-check mr-2"></i>
                                                <span class="font-weight-bold small text-uppercase">{{ __('admin/setting.footer_settings') }}</span></a>
                                            <a class="nav-link mb-3 p-3 shadow" id="v-pills-pages-tab" data-toggle="pill" href="#v-pills-pages" role="tab" aria-controls="v-pills-pages" aria-selected="false">
                                                <i class="fa fa-check mr-2"></i>
                                                <span class="font-weight-bold small text-uppercase">{{ __('admin/setting.pages_settings') }}</span></a>
                                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/setting.update') }}</button>
                                        </div>
                                    </div>


                                    <div class="col-md-9">
                                        <!-- Tabs content -->
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade shadow rounded bg-white show active p-5" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                                                <div class="clearfix mb-10">
                                                    <div class="pull-left">
                                                        <h4 class="text-blue h4">{{ __('admin/setting.genral_settings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_name') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*site_name'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#site_name-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="site_name-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[site_name]" placeholder="{{ __('admin/setting.site_name') }}" value="{{ $setting->translate($key)->site_name }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*site_name')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*site_name'))<span class="text-danger">{{ $errors->first($key.'*site_name') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_url') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="site_url" placeholder="{{ __('admin/setting.site_url') }}" value="{{ $setting->site_url }}" class="border-gray-300 rounded-md shadow-sm form-control @error('site_url') border border-danger @enderror" type="text"/>
                                                        @error('site_url')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_lang') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="lang" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('lang') border border-danger @enderror">
                                                            <option>Choose...</option>
                                                            <option value="ar" @if($setting->lang == 'ar') selected @endif>{{ __('admin/setting.site_lang_ar') }}</option>
                                                            <option value="en" @if($setting->lang == 'en') selected @endif>{{ __('admin/setting.site_lang_en') }}</option>
                                                        </select>
                                                        @error('lang')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.currency') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="currency" placeholder="{{ __('admin/setting.currency') }}" value="{{ $setting->currency }}" class="border-gray-300 rounded-md shadow-sm form-control @error('currency') border border-danger @enderror" type="text"/>
                                                        @error('currency')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.currency_iso') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="currency_iso" placeholder="{{ __('admin/setting.currency_iso') }}" value="{{ $setting->currency_iso }}" class="border-gray-300 rounded-md shadow-sm form-control @error('currency_iso') border border-danger @enderror" type="text"/>
                                                        @error('currency_iso')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.payment_getway_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="payment_getway_st" id="payment_getway_st" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('payment_getway_st') border border-danger @enderror">
                                                            <option value="" @if($setting->payment_getway_st == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="enabled" @if($setting->payment_getway_st == 'enabled') selected @endif>{{ __('admin/setting.enabled') }}</option>
                                                            <option value="disabled" @if($setting->payment_getway_st == 'disabled') selected @endif>{{ __('admin/setting.disabled') }}</option>
                                                        </select>
                                                        @error('payment_getway_st')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.fatoora_base_url') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="fatoora_base_url" placeholder="{{ __('admin/setting.fatoora_base_url') }}" value="{{ $setting->fatoora_base_url }}" class="border-gray-300 rounded-md shadow-sm form-control @error('fatoora_base_url') border border-danger @enderror" type="text"/>
                                                        @error('fatoora_base_url')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.fatoora_token') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea name="fatoora_token" placeholder="{{ __('admin/setting.fatoora_token') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('fatoora_token') border border-danger @enderror">{{ $setting->fatoora_token }}</textarea>
                                                        @error('fatoora_token')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_slogan') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*site_slogan'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#site_slogan-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="site_slogan-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[site_slogan]" placeholder="{{ __('admin/setting.site_slogan') }}" value="{{ $setting->translate($key)->site_slogan }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*site_slogan')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*site_slogan'))<span class="text-danger">{{ $errors->first($key.'*site_slogan') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_perpage') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="posts_per_page" placeholder="{{ __('admin/setting.site_perpage') }}" value="{{ $setting->posts_per_page }}" class="border-gray-300 rounded-md shadow-sm form-control @error('posts_per_page') border border-danger @enderror" type="text"/>
                                                        @error('posts_per_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_meta_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*site_meta_description'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#site_meta_description-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="site_meta_description-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[site_meta_description]" placeholder="{{ __('admin/setting.site_meta_desc') }}" value="{{ $setting->translate($key)->site_meta_description }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*site_meta_description')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*site_meta_description'))<span class="text-danger">{{ $errors->first($key.'*site_meta_description') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_meta_tags') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*site_meta_keywords'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#site_meta_keywords-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="site_meta_keywords-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[site_meta_keywords]" placeholder="{{ __('admin/setting.site_meta_tags') }}" value="{{ $setting->translate($key)->site_meta_keywords }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*site_meta_keywords')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*site_meta_keywords'))<span class="text-danger">{{ $errors->first($key.'*site_meta_keywords') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row" id="user_image_field_{{$field1}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_logo') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="site_logo" id="user_image_{{$field1}}" placeholder="{{ __('admin/setting.site_logo') }}" value="{{ $setting->site_logo }}" class="hidden form-control @error('site_logo') border border-danger @enderror" type="text"/>
                                                        @error('site_logo')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->site_logo)
                                                                <img src="{{ $setting->site_logo }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field1 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>


                                                <div class="form-group row" id="user_image_field_{{$field2}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_favicon') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="site_favicon" id="user_image_{{$field2}}" placeholder="{{ __('admin/setting.site_favicon') }}" value="{{ $setting->site_favicon }}" class="hidden form-control @error('site_favicon') border border-danger @enderror" type="text"/>
                                                        @error('site_favicon')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->site_favicon)
                                                                <img src="{{ $setting->site_favicon }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field2}}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_status') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="site_status" id="site_status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('site_status') border border-danger @enderror">
                                                            <option value="" @if($setting->site_status == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="publish" @if($setting->site_status == 'publish') selected @endif>{{ __('admin/setting.publish') }}</option>
                                                            <option value="closed" @if($setting->site_status == 'closed') selected @endif>{{ __('admin/setting.closed') }}</option>
                                                        </select>
                                                        @error('site_status')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row close_msg" @if($setting->site_status != 'closed') style="display: none" @endif>
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_close_msg') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*close_msg'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#close_msg-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="close_msg-{{ $key }}" role="tabpanel">
                                                                    <textarea name="{{ $key }}[close_msg]" placeholder="{{ __('admin/setting.site_close_msg') }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*close_msg')) border border-danger @endif" >{{ $setting->translate($key)->close_msg }}</textarea>
                                                                    @if($errors->has($key.'*close_msg'))<span class="text-danger">{{ $errors->first($key.'*close_msg') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.dashboard_perpage') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="admin_paginate" placeholder="{{ __('admin/setting.dashboard_perpage') }}" value="{{ $setting->admin_paginate }}" class="border-gray-300 rounded-md shadow-sm form-control @error('admin_paginate') border border-danger @enderror" type="text"/>
                                                        @error('admin_paginate')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>



                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_comments_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="comments_mode" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('comments_mode') border border-danger @enderror">
                                                            <option value="" @if($setting->comments_mode == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="open" @if($setting->comments_mode == 'open') selected @endif>{{ __('admin/setting.open') }}</option>
                                                            <option value="closed" @if($setting->comments_mode == 'closed') selected @endif>{{ __('admin/setting.closed') }}</option>
                                                        </select>
                                                        @error('comments_mode')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_default_comments_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="user_comment_status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('user_comment_status') border border-danger @enderror">
                                                            <option value="" @if($setting->user_comment_status == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="publish" @if($setting->user_comment_status == 'publish') selected @endif>{{ __('admin/setting.publish') }}</option>
                                                            <option value="pending" @if($setting->user_comment_status == 'pending') selected @endif>{{ __('admin/setting.pending') }}</option>
                                                            <option value="draft" @if($setting->user_comment_status == 'draft') selected @endif>{{ __('admin/setting.draft') }}</option>
                                                        </select>
                                                        @error('user_comment_status')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.facebook') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="facebook" placeholder="{{ __('admin/setting.facebook') }}" value="{{ $setting->facebook }}" class="border-gray-300 rounded-md shadow-sm form-control @error('facebook') border border-danger @enderror" type="text"/>
                                                        @error('facebook')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.twitter') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="twitter" placeholder="{{ __('admin/setting.twitter') }}" value="{{ $setting->twitter }}" class="border-gray-300 rounded-md shadow-sm form-control @error('twitter') border border-danger @enderror" type="text"/>
                                                        @error('twitter')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.youtube') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="youtube" placeholder="{{ __('admin/setting.youtube') }}" value="{{ $setting->youtube }}" class="border-gray-300 rounded-md shadow-sm form-control @error('youtube') border border-danger @enderror" type="text"/>
                                                        @error('youtube')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.instagram') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="instagram" placeholder="{{ __('admin/setting.instagram') }}" value="{{ $setting->instagram }}" class="border-gray-300 rounded-md shadow-sm form-control @error('instagram') border border-danger @enderror" type="text"/>
                                                        @error('instagram')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.email') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="email" placeholder="{{ __('admin/setting.email') }}" value="{{ $setting->email }}" class="border-gray-300 rounded-md shadow-sm form-control @error('email') border border-danger @enderror" type="text"/>
                                                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.phone') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="phone" placeholder="{{ __('admin/setting.phone') }}" value="{{ $setting->phone }}" class="border-gray-300 rounded-md shadow-sm form-control @error('phone') border border-danger @enderror" type="text"/>
                                                        @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.contact_opening') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*contact_opening'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#contact_opening-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="contact_opening-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[contact_opening]" placeholder="{{ __('admin/setting.contact_opening') }}" value="{{ $setting->translate($key)->contact_opening }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*contact_opening')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*contact_opening'))<span class="text-danger">{{ $errors->first($key.'*contact_opening') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.map_link') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="map_link" placeholder="{{ __('admin/setting.map_link') }}" value="{{ $setting->map_link }}" class="border-gray-300 rounded-md shadow-sm form-control @error('map_link') border border-danger @enderror" type="text"/>
                                                        @error('map_link')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.realadventures_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="realadventures_page" placeholder="{{ __('admin/setting.realadventures_page') }}" value="{{ $setting->realadventures_page }}" class="border-gray-300 rounded-md shadow-sm form-control @error('realadventures_page') border border-danger @enderror" type="text"/>
                                                        @error('realadventures_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.tripadvisor_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="tripadvisor_page" placeholder="{{ __('admin/setting.tripadvisor_page') }}" value="{{ $setting->tripadvisor_page }}" class="border-gray-300 rounded-md shadow-sm form-control @error('tripadvisor_page') border border-danger @enderror" type="text"/>
                                                        @error('tripadvisor_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_adress') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*footer_adress'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#footer_adress-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="footer_adress-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[footer_adress]" placeholder="{{ __('admin/setting.footer_adress') }}" value="{{ $setting->translate($key)->footer_adress }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*footer_adress')) border border-danger @endif" type="text" />
                                                                    @if($errors->has($key.'*footer_adress'))<span class="text-danger">{{ $errors->first($key.'*footer_adress') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.tawk_code') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <textarea name="tawk_code" placeholder="{{ __('admin/setting.tawk_code') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('tawk_code') border border-danger @enderror">{{ $setting->tawk_code }}</textarea>
                                                        @error('tawk_code')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade shadow rounded bg-white p-5" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

                                                <div class="clearfix mb-10">
                                                    <div class="pull-left">
                                                        <h4 class="text-blue h4">{{ __('admin/setting.header_settings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.header_menu') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="header_menu" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('header_menu') border border-danger @enderror">
                                                            <option value="" @if($setting->header_menu == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            @foreach($menus as $menu)
                                                                <option value="{{ $menu->id }}" @if($setting->header_menu == $menu->id) selected @endif>{{ $menu->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('header_menu')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.book_menu_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="book_menu_st" id="book_menu_st" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('book_menu_st') border border-danger @enderror">
                                                            <option value="" @if($setting->book_menu_st == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="enabled" @if($setting->book_menu_st == 'enabled') selected @endif>{{ __('admin/setting.enabled') }}</option>
                                                            <option value="disabled" @if($setting->book_menu_st == 'disabled') selected @endif>{{ __('admin/setting.disabled') }}</option>
                                                        </select>
                                                        @error('book_menu_st')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.langs_menu_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="langs_menu_st" id="langs_menu_st" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('langs_menu_st') border border-danger @enderror">
                                                            <option value="" @if($setting->langs_menu_st == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="enabled" @if($setting->langs_menu_st == 'enabled') selected @endif>{{ __('admin/setting.enabled') }}</option>
                                                            <option value="disabled" @if($setting->langs_menu_st == 'disabled') selected @endif>{{ __('admin/setting.disabled') }}</option>
                                                        </select>
                                                        @error('langs_menu_st')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.login_menu_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="login_menu_st" id="login_menu_st" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('login_menu_st') border border-danger @enderror">
                                                            <option value="" @if($setting->login_menu_st == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="enabled" @if($setting->login_menu_st == 'enabled') selected @endif>{{ __('admin/setting.enabled') }}</option>
                                                            <option value="disabled" @if($setting->login_menu_st == 'disabled') selected @endif>{{ __('admin/setting.disabled') }}</option>
                                                        </select>
                                                        @error('login_menu_st')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.book_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="book_page" placeholder="{{ __('admin/setting.book_page') }}" value="{{ $setting->book_page }}" class="border-gray-300 rounded-md shadow-sm form-control @error('book_page') border border-danger @enderror" type="text"/>
                                                        @error('book_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade shadow rounded bg-white p-5" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

                                                <div class="clearfix mb-10">
                                                    <div class="pull-left">
                                                        <h4 class="text-blue h4">{{ __('admin/setting.home_settings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.slider_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="slider_st" id="slider_st" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('slider_st') border border-danger @enderror">
                                                            <option value="" @if($setting->slider_st == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="enabled" @if($setting->slider_st == 'enabled') selected @endif>{{ __('admin/setting.enabled') }}</option>
                                                            <option value="disabled" @if($setting->slider_st == 'disabled') selected @endif>{{ __('admin/setting.disabled') }}</option>
                                                        </select>
                                                        @error('slider_st')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row slider" @if($setting->slider_st != 'enabled') style="display: none" @endif>
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.slider') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*slider'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#slider-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="slider-{{ $key }}" role="tabpanel">

                                                                    <table class="table table-bordered" id="slider_table_{{ $key }}">
                                                                        <tr>
                                                                            <th>{{ __('admin/setting.slider_title') }}</th>
                                                                            <th>{{ __('admin/setting.slider_desc') }}</th>
                                                                            <th>{{ __('admin/setting.slider_image') }}</th>
                                                                            <th>{{ __('admin/setting.slider_link') }}</th>
                                                                            <th>{{ __('admin/setting.slider_link_text') }}</th>
                                                                            <th><button type="button" class="btn btn-success btn-sm add_slider_{{ $key }}" data-id="" style="background: green;"><span class="fa fa-plus"></span></button></th>
                                                                        </tr>
                                                                        @php
                                                                            $sliders = json_decode($setting->translate($key)->slider, true);
                                                                            $slides = array_values($sliders);
                                                                        @endphp
                                                                        @if(!empty($slides))
                                                                            @if(is_array($slides))
                                                                                @php $ii = 0; @endphp
                                                                                @for($i = 0; $i < count($slides[0]); $i++)

                                                                                    <tr>
                                                                                        <td><input type="text" name="{{ $key }}[slider][title][]" value="{{ $slides[0][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><input type="text" name="{{ $key }}[slider][desc][]" value="{{ $slides[1][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><input type="text" name="{{ $key }}[slider][image][]" value="{{ $slides[2][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><input type="text" name="{{ $key }}[slider][link][]" value="{{ $slides[3][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><input type="text" name="{{ $key }}[slider][link_text][]" value="{{ $slides[4][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><button type="button" class="btn btn-danger btn-sm slider_remove" style="background: red;"><span class="fa fa-minus"></span></button></td>
                                                                                    </tr>
                                                                                    @php $ii++; @endphp
                                                                                @endfor
                                                                            @endif
                                                                        @endif
                                                                    </table>

                                                                    @if($errors->has($key.'*slider'))<span class="text-danger">{{ $errors->first($key.'*slider') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.search_st') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="search_st" id="search_st" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('search_st') border border-danger @enderror">
                                                            <option value="" @if($setting->search_st == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            <option value="enabled" @if($setting->search_st == 'enabled') selected @endif>{{ __('admin/setting.enabled') }}</option>
                                                            <option value="disabled" @if($setting->search_st == 'disabled') selected @endif>{{ __('admin/setting.disabled') }}</option>
                                                        </select>
                                                        @error('search_st')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_title]" placeholder="{{ __('admin/setting.about_title') }}" value="{{ $setting->translate($key)->about_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_title'))<span class="text-danger">{{ $errors->first($key.'*about_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_desc]" placeholder="{{ __('admin/setting.about_desc') }}" value="{{ $setting->translate($key)->about_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_desc'))<span class="text-danger">{{ $errors->first($key.'*about_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_content') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_content'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_content-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_content-{{ $key }}" role="tabpanel">
                                                                    <textarea name="{{ $key }}[about_content]" placeholder="{{ __('admin/setting.about_content') }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_content')) border border-danger @endif">{{ $setting->translate($key)->about_content }}</textarea>
                                                                    @if($errors->has($key.'*about_content'))<span class="text-danger">{{ $errors->first($key.'*about_content') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_admin') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_admin'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_admin-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_admin-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_admin]" placeholder="{{ __('admin/setting.about_admin') }}" value="{{ $setting->translate($key)->about_admin }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_admin')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_admin'))<span class="text-danger">{{ $errors->first($key.'*about_admin') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_blocks') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_blocks'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_blocks-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_blocks-{{ $key }}" role="tabpanel">

                                                                    <table class="table table-bordered" id="about_table_{{ $key }}">
                                                                        <tr>
                                                                            <th>{{ __('admin/setting.about_blocks_title') }}</th>
                                                                            <th>{{ __('admin/setting.about_blocks_image') }}</th>
                                                                            <th><button type="button" class="btn btn-success btn-sm add_about_{{ $key }}" data-id="" style="background: green;"><span class="fa fa-plus"></span></button></th>
                                                                        </tr>
                                                                        @php
                                                                            $abouts = json_decode($setting->translate($key)->about_blocks, true);
                                                                            $about_slides = array_values($abouts);
                                                                        @endphp
                                                                        @if(!empty($about_slides))
                                                                            @if(is_array($about_slides))
                                                                                @for($i = 0; $i < count($about_slides[0]); $i++)
                                                                                    <tr>
                                                                                        <td><input type="text" name="{{ $key }}[about_blocks][title][]" value="{{ $about_slides[0][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><input type="text" name="{{ $key }}[about_blocks][image][]" value="{{ $about_slides[1][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><button type="button" class="btn btn-danger btn-sm about_remove" style="background: red;"><span class="fa fa-minus"></span></button></td>
                                                                                    </tr>
                                                                                @endfor
                                                                            @endif
                                                                        @endif
                                                                    </table>

                                                                    @if($errors->has($key.'*about_blocks'))<span class="text-danger">{{ $errors->first($key.'*about_blocks') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="user_image_field_{{$field3}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_img1') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="about_img1" id="user_image_{{$field3}}" placeholder="{{ __('admin/setting.about_img1') }}" value="{{ $setting->about_img1 }}" class="hidden form-control @error('about_img1') border border-danger @enderror" type="text"/>
                                                        @error('about_img1')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->about_img1)
                                                                <img src="{{ $setting->about_img1 }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field3 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="user_image_field_{{$field4}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_img2') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="about_img2" id="user_image_{{$field4}}" placeholder="{{ __('admin/setting.about_img2') }}" value="{{ $setting->about_img2 }}" class="hidden form-control @error('about_img2') border border-danger @enderror" type="text"/>
                                                        @error('about_img2')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->about_img2)
                                                                <img src="{{ $setting->about_img2 }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field4 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="user_image_field_{{$field5}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_img3') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="about_img3" id="user_image_{{$field5}}" placeholder="{{ __('admin/setting.about_img3') }}" value="{{ $setting->about_img3 }}" class="hidden form-control @error('about_img3') border border-danger @enderror" type="text"/>
                                                        @error('about_img3')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->about_img3)
                                                                <img src="{{ $setting->about_img3 }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field5 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="user_image_field_{{$field6}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_img4') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="about_img4" id="user_image_{{$field6}}" placeholder="{{ __('admin/setting.about_img4') }}" value="{{ $setting->about_img4 }}" class="hidden form-control @error('about_img4') border border-danger @enderror" type="text"/>
                                                        @error('about_img4')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->about_img4)
                                                                <img src="{{ $setting->about_img4 }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field6 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.contact_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*contact_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#contact_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="contact_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[contact_title]" placeholder="{{ __('admin/setting.contact_title') }}" value="{{ $setting->translate($key)->contact_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*contact_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*contact_title'))<span class="text-danger">{{ $errors->first($key.'*contact_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.contact_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*contact_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#contact_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="contact_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[contact_desc]" placeholder="{{ __('admin/setting.contact_desc') }}" value="{{ $setting->translate($key)->contact_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*contact_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*contact_desc'))<span class="text-danger">{{ $errors->first($key.'*contact_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.tours_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*tours_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#tours_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="tours_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[tours_title]" placeholder="{{ __('admin/setting.tours_title') }}" value="{{ $setting->translate($key)->tours_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*tours_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*tours_title'))<span class="text-danger">{{ $errors->first($key.'*tours_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.tours_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*tours_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#tours_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="tours_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[tours_desc]" placeholder="{{ __('admin/setting.tours_desc') }}" value="{{ $setting->translate($key)->tours_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*tours_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*tours_desc'))<span class="text-danger">{{ $errors->first($key.'*tours_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.tours_count') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="tours_count" placeholder="{{ __('admin/setting.tours_count') }}" value="{{ $setting->tours_count }}" class="border-gray-300 rounded-md shadow-sm form-control @error('tours_count') border border-danger @enderror" type="text"/>
                                                        @error('tours_count')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.testimonials_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*testimonials_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#testimonials_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="testimonials_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[testimonials_title]" placeholder="{{ __('admin/setting.testimonials_title') }}" value="{{ $setting->translate($key)->testimonials_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*testimonials_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*testimonials_title'))<span class="text-danger">{{ $errors->first($key.'*testimonials_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.testimonials_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*testimonials_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#testimonials_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="testimonials_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[testimonials_desc]" placeholder="{{ __('admin/setting.testimonials_desc') }}" value="{{ $setting->translate($key)->testimonials_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*testimonials_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*testimonials_desc'))<span class="text-danger">{{ $errors->first($key.'*testimonials_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.testimonials_count') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="testimonials_count" placeholder="{{ __('admin/setting.testimonials_count') }}" value="{{ $setting->testimonials_count }}" class="border-gray-300 rounded-md shadow-sm form-control @error('testimonials_count') border border-danger @enderror" type="text"/>
                                                        @error('testimonials_count')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.news_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*news_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#news_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="news_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[news_title]" placeholder="{{ __('admin/setting.news_title') }}" value="{{ $setting->translate($key)->news_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*news_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*news_title'))<span class="text-danger">{{ $errors->first($key.'*news_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.news_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*news_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#news_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="news_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[news_desc]" placeholder="{{ __('admin/setting.news_desc') }}" value="{{ $setting->translate($key)->news_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*news_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*news_desc'))<span class="text-danger">{{ $errors->first($key.'*news_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.news_count') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="news_count" placeholder="{{ __('admin/setting.news_count') }}" value="{{ $setting->news_count }}" class="border-gray-300 rounded-md shadow-sm form-control @error('news_count') border border-danger @enderror" type="text"/>
                                                        @error('news_count')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.images_count') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="images_count" placeholder="{{ __('admin/setting.images_count') }}" value="{{ $setting->images_count }}" class="border-gray-300 rounded-md shadow-sm form-control @error('images_count') border border-danger @enderror" type="text"/>
                                                        @error('images_count')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade shadow rounded bg-white p-5" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">

                                                <div class="clearfix mb-10">
                                                    <div class="pull-left">
                                                        <h4 class="text-blue h4">{{ __('admin/setting.footer_settings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>

                                                <div class="form-group row" id="user_image_field_{{$field7}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_logo') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="footer_logo" id="user_image_{{$field7}}" placeholder="{{ __('admin/setting.footer_logo') }}" value="{{ $setting->footer_logo }}" class="hidden form-control @error('footer_logo') border border-danger @enderror" type="text"/>
                                                        @error('footer_logo')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->footer_logo)
                                                                <img src="{{ $setting->footer_logo }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field7 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_menu_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*footer_menu_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#footer_menu_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="footer_menu_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[footer_menu_title]" placeholder="{{ __('admin/setting.footer_menu_title') }}" value="{{ $setting->translate($key)->footer_menu_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*footer_menu_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*footer_menu_title'))<span class="text-danger">{{ $errors->first($key.'*footer_menu_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_menu') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="footer_menu" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('footer_menu') border border-danger @enderror">
                                                            <option value="" @if($setting->footer_menu == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                                            @foreach($menus as $menu)
                                                                <option value="{{ $menu->id }}" @if($setting->footer_menu == $menu->id) selected @endif>{{ $menu->title }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('footer_menu')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_subscribe_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*footer_subscribe_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#footer_subscribe_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="footer_subscribe_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[footer_subscribe_title]" placeholder="{{ __('admin/setting.footer_subscribe_title') }}" value="{{ $setting->translate($key)->footer_subscribe_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*footer_subscribe_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*footer_subscribe_title'))<span class="text-danger">{{ $errors->first($key.'*footer_subscribe_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_subscribe_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*footer_subscribe_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#footer_subscribe_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="footer_subscribe_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[footer_subscribe_desc]" placeholder="{{ __('admin/setting.footer_subscribe_desc') }}" value="{{ $setting->translate($key)->footer_subscribe_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*footer_subscribe_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*footer_subscribe_desc'))<span class="text-danger">{{ $errors->first($key.'*footer_subscribe_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_blog_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*footer_blog_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#footer_blog_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="footer_blog_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[footer_blog_title]" placeholder="{{ __('admin/setting.footer_blog_title') }}" value="{{ $setting->translate($key)->footer_blog_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*footer_blog_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*footer_blog_title'))<span class="text-danger">{{ $errors->first($key.'*footer_blog_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.footer_blog_count') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="footer_blog_count" placeholder="{{ __('admin/setting.footer_blog_count') }}" value="{{ $setting->footer_blog_count }}" class="border-gray-300 rounded-md shadow-sm form-control @error('footer_blog_count') border border-danger @enderror" type="text"/>
                                                        @error('footer_blog_count')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="tab-pane fade shadow rounded bg-white p-5" id="v-pills-pages" role="tabpanel" aria-labelledby="v-pills-pages-tab">

                                                <div class="clearfix mb-10">
                                                    <div class="pull-left">
                                                        <h4 class="text-blue h4">{{ __('admin/setting.pages_settings') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="about_page" class="custom-select border-gray-300 rounded-md shadow-sm form-control @error('about_page') border border-danger @enderror">
                                                            @if(count($pages) > 0)
                                                                @foreach($pages as $page)
                                                                    <option value="{{ $page->id }}" @if($page->id == $setting->about_page) selected @endif >{{ $page->title }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('about_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.contact_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="contact_page" class="custom-select border-gray-300 rounded-md shadow-sm form-control @error('contact_page') border border-danger @enderror">
                                                            @if(count($pages) > 0)
                                                                @foreach($pages as $page)
                                                                    <option value="{{ $page->id }}" @if($page->id == $setting->contact_page) selected @endif >{{ $page->title }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('contact_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.tours_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="tours_page" class="custom-select border-gray-300 rounded-md shadow-sm form-control @error('tours_page') border border-danger @enderror">
                                                            @if(count($pages) > 0)
                                                                @foreach($pages as $page)
                                                                    <option value="{{ $page->id }}" @if($page->id == $setting->tours_page) selected @endif >{{ $page->title }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('tours_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.testimonials_page') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <select name="testimonials_page" class="custom-select border-gray-300 rounded-md shadow-sm form-control @error('testimonials_page') border border-danger @enderror">
                                                            @if(count($pages) > 0)
                                                                @foreach($pages as $page)
                                                                    <option value="{{ $page->id }}" @if($page->id == $setting->testimonials_page) selected @endif >{{ $page->title }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('testimonials_page')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="clearfix mb-10">
                                                    <div class="pull-left">
                                                        <h4 class="text-blue h4">{{ __('admin/setting.pages_about') }}</h4>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider"></div>


                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec1_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec1_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec1_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec1_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_sec1_title]" placeholder="{{ __('admin/setting.about_sec1_title') }}" value="{{ $setting->translate($key)->about_sec1_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec1_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_sec1_title'))<span class="text-danger">{{ $errors->first($key.'*about_sec1_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec1_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec1_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec1_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec1_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_sec1_desc]" placeholder="{{ __('admin/setting.about_sec1_desc') }}" value="{{ $setting->translate($key)->about_sec1_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec1_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_sec1_desc'))<span class="text-danger">{{ $errors->first($key.'*about_sec1_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec1_data') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec1_data'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec1_data-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec1_data-{{ $key }}" role="tabpanel">
                                                                    <textarea name="{{ $key }}[about_sec1_data]" placeholder="{{ __('admin/setting.about_sec1_data') }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec1_data')) border border-danger @endif">{{ $setting->translate($key)->about_sec1_data }}</textarea>
                                                                    @if($errors->has($key.'*about_sec1_data'))<span class="text-danger">{{ $errors->first($key.'*about_sec1_data') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="user_image_field_{{$field8}}">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec1_img') }}</label>
                                                    <div class="col-sm-6 col-md-6 hidden">
                                                        <input name="about_sec1_img" id="user_image_{{$field8}}" placeholder="{{ __('admin/setting.about_sec1_img') }}" value="{{ $setting->about_sec1_img }}" class="hidden form-control @error('about_sec1_img') border border-danger @enderror" type="text"/>
                                                        @error('about_sec1_img')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                    <div class="col-sm-12 col-md-10">
                                                        {{--@livewire('admin.media-upload')--}}
                                                        <div class="image_preview" style="float: left; margin-right: 20px;">
                                                            @if($setting->about_sec1_img)
                                                                <img src="{{ $setting->about_sec1_img }}" width="100" />
                                                            @endif
                                                        </div>
                                                        <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field8 }}" type="button">{{ __('admin/setting.media') }}</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec2_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec2_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec2_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec2_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_sec2_title]" placeholder="{{ __('admin/setting.about_sec2_title') }}" value="{{ $setting->translate($key)->about_sec2_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec2_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_sec2_title'))<span class="text-danger">{{ $errors->first($key.'*about_sec2_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec2_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec2_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec2_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec2_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_sec2_desc]" placeholder="{{ __('admin/setting.about_sec2_desc') }}" value="{{ $setting->translate($key)->about_sec2_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec2_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_sec2_desc'))<span class="text-danger">{{ $errors->first($key.'*about_sec2_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec2_link') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <input name="about_sec2_link" placeholder="{{ __('admin/setting.about_sec2_link') }}" value="{{ $setting->about_sec2_link }}" class="border-gray-300 rounded-md shadow-sm form-control @error('about_sec2_link') border border-danger @enderror" type="text"/>
                                                        @error('about_sec2_link')<span class="text-danger">{{ $message }}</span>@enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec3_title') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec3_title'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec3_title-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec3_title-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_sec3_title]" placeholder="{{ __('admin/setting.about_sec3_title') }}" value="{{ $setting->translate($key)->about_sec3_title }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec3_title')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_sec3_title'))<span class="text-danger">{{ $errors->first($key.'*about_sec3_title') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec3_desc') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec3_desc'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec3_desc-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec3_desc-{{ $key }}" role="tabpanel">
                                                                    <input name="{{ $key }}[about_sec3_desc]" placeholder="{{ __('admin/setting.about_sec3_desc') }}" value="{{ $setting->translate($key)->about_sec3_desc }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*about_sec3_desc')) border border-danger @endif" type="text"/>
                                                                    @if($errors->has($key.'*about_sec3_desc'))<span class="text-danger">{{ $errors->first($key.'*about_sec3_desc') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.about_sec3') }}</label>
                                                    <div class="col-sm-12 col-md-10">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <li class="nav-item @if($errors->has($key.'*about_sec3'))  border border-danger @endif">
                                                                    <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#about_sec3-{{ $key }}" role="tab">{{ $lang }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul><!-- Tab panes -->
                                                        <div class="tab-content">
                                                            @foreach(config('translatable.languages') as $key => $lang)
                                                                <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="about_sec3-{{ $key }}" role="tabpanel">

                                                                    <table class="table table-bordered" id="about_sec3_table_{{ $key }}">
                                                                        <tr>
                                                                            <th>{{ __('admin/setting.about_sec3_htitle') }}</th>
                                                                            <th>{{ __('admin/setting.about_sec3_himage') }}</th>
                                                                            <th><button type="button" class="btn btn-success btn-sm add_about_sec3_{{ $key }}" data-id="" style="background: green;"><span class="fa fa-plus"></span></button></th>
                                                                        </tr>
                                                                        @php
                                                                            $about_sec3 = json_decode($setting->translate($key)->about_sec3, true);
                                                                            $about_sec3_slides = array_values($about_sec3);
                                                                        @endphp
                                                                        @if(!empty($about_sec3_slides))
                                                                            @if(is_array($about_sec3_slides))
                                                                                @for($i = 0; $i < count($about_sec3_slides[0]); $i++)
                                                                                    <tr>
                                                                                        <td><input type="text" name="{{ $key }}[about_sec3][title][]" value="{{ $about_sec3_slides[0][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><input type="text" name="{{ $key }}[about_sec3][image][]" value="{{ $about_sec3_slides[1][$i] }}" class="form-control item_quantity" /></td>
                                                                                        <td><button type="button" class="btn btn-danger btn-sm about_sec3_remove" style="background: red;"><span class="fa fa-minus"></span></button></td>
                                                                                    </tr>
                                                                                @endfor
                                                                            @endif
                                                                        @endif
                                                                    </table>

                                                                    @if($errors->has($key.'*about_sec3'))<span class="text-danger">{{ $errors->first($key.'*about_sec3') }}</span>@endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                </form>


            </div>
        </div>
    </div>

    <div id="user_image_modal_{{$field1}}">
        <livewire:admin.media-box :field="$field1"  />
    </div>

    <div id="user_image_modal_{{$field2}}">
        <livewire:admin.media-box :field="$field2"  />
    </div>

    <div id="user_image_modal_{{$field3}}">
        <livewire:admin.media-box :field="$field3"  />
    </div>

    <div id="user_image_modal_{{$field4}}">
        <livewire:admin.media-box :field="$field4"  />
    </div>

    <div id="user_image_modal_{{$field5}}">
        <livewire:admin.media-box :field="$field5"  />
    </div>

    <div id="user_image_modal_{{$field6}}">
        <livewire:admin.media-box :field="$field6"  />
    </div>

    <div id="user_image_modal_{{$field7}}">
        <livewire:admin.media-box :field="$field7"  />
    </div>

    <div id="user_image_modal_{{$field8}}">
        <livewire:admin.media-box :field="$field8"  />
    </div>


    @section('scripts')
        <script>
            $('#user_image_modal_{{$field1}} #gallery_{{$field1}} a.image_ch').click(function(){
                $('#user_image_field_{{$field1}} #user_image_{{$field1}}').val($(this).data('image'));
                var value = $("#user_image_{{$field1}}").val();
                $("#user_image_field_{{$field1}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field1}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field1}} #user_image_{{$field1}}').val('');
                    $("#user_image_field_{{$field1}} .image_preview a.remove_img").remove();
                });
                //$('.media_uploader').modal('hide');
            });

            $('#user_image_modal_{{$field2}} #gallery_{{$field2}} a.image_ch').click(function(){
                $('#user_image_field_{{$field2}} #user_image_{{$field2}}').val($(this).data('image'));
                var value = $("#user_image_{{$field2}}").val();
                $("#user_image_field_{{$field2}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field2}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field2}} #user_image_{{$field2}}').val('');
                    $("#user_image_field_{{$field2}} .image_preview a.remove_img").remove();
                });
            });

            $('#user_image_modal_{{$field3}} #gallery_{{$field3}} a.image_ch').click(function(){
                $('#user_image_field_{{$field3}} #user_image_{{$field3}}').val($(this).data('image'));
                var value = $("#user_image_{{$field3}}").val();
                $("#user_image_field_{{$field3}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field3}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field3}} #user_image_{{$field3}}').val('');
                    $("#user_image_field_{{$field3}} .image_preview a.remove_img").remove();
                });
            });

            $('#user_image_modal_{{$field4}} #gallery_{{$field4}} a.image_ch').click(function(){
                $('#user_image_field_{{$field4}} #user_image_{{$field4}}').val($(this).data('image'));
                var value = $("#user_image_{{$field4}}").val();
                $("#user_image_field_{{$field4}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field4}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field4}} #user_image_{{$field4}}').val('');
                    $("#user_image_field_{{$field4}} .image_preview a.remove_img").remove();
                });
            });

            $('#user_image_modal_{{$field5}} #gallery_{{$field5}} a.image_ch').click(function(){
                $('#user_image_field_{{$field5}} #user_image_{{$field5}}').val($(this).data('image'));
                var value = $("#user_image_{{$field5}}").val();
                $("#user_image_field_{{$field5}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field5}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field5}} #user_image_{{$field5}}').val('');
                    $("#user_image_field_{{$field5}} .image_preview a.remove_img").remove();
                });
            });

            $('#user_image_modal_{{$field6}} #gallery_{{$field6}} a.image_ch').click(function(){
                $('#user_image_field_{{$field6}} #user_image_{{$field6}}').val($(this).data('image'));
                var value = $("#user_image_{{$field6}}").val();
                $("#user_image_field_{{$field6}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field6}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field6}} #user_image_{{$field6}}').val('');
                    $("#user_image_field_{{$field6}} .image_preview a.remove_img").remove();
                });
            });

            $('#user_image_modal_{{$field7}} #gallery_{{$field7}} a.image_ch').click(function(){
                $('#user_image_field_{{$field7}} #user_image_{{$field7}}').val($(this).data('image'));
                var value = $("#user_image_{{$field7}}").val();
                $("#user_image_field_{{$field7}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field7}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field7}} #user_image_{{$field7}}').val('');
                    $("#user_image_field_{{$field7}} .image_preview a.remove_img").remove();
                });
            });

            $('#user_image_modal_{{$field8}} #gallery_{{$field8}} a.image_ch').click(function(){
                $('#user_image_field_{{$field8}} #user_image_{{$field8}}').val($(this).data('image'));
                var value = $("#user_image_{{$field8}}").val();
                $("#user_image_field_{{$field8}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field8}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field8}} #user_image_{{$field8}}').val('');
                    $("#user_image_field_{{$field8}} .image_preview a.remove_img").remove();
                });
            });

            $("#site_status").change(function() {
                if ($(this).val() === 'closed'){
                    $('.close_msg').show();
                } else {
                    $('.close_msg').hide();
                }
            });

            $("#slider_st").change(function() {
                if ($(this).val() === 'enabled'){
                    $('.slider').show();
                } else {
                    $('.slider').hide();
                }
            });

            $("#registeration_status").change(function() {
                if ($(this).val() === 'closed'){
                    $('.registeration_status_msg').show();
                } else {
                    $('.registeration_status_msg').hide();
                }
            });


            $(document).on('click', '#slider_table_ar .add_slider_ar', function(){
                var slider_html_ar = '';
                slider_html_ar += '<tr>';
                slider_html_ar += '<td><input type="text" name="ar[slider][title][]" class="form-control" /></td>';
                slider_html_ar += '<td><input type="text" name="ar[slider][desc][]" class="form-control" /></td>';
                slider_html_ar += '<td><input type="text" name="ar[slider][image][]" class="form-control" /></td>';
                slider_html_ar += '<td><input type="text" name="ar[slider][link][]" class="form-control" /></td>';
                slider_html_ar += '<td><input type="text" name="ar[slider][link_text][]" class="form-control" /></td>';
                slider_html_ar += '<td><button type="button" class="btn btn-danger btn-sm slider_remove" style="background: red;"><span class="fa fa-minus"></span></button></td></tr>';
                $('#slider_table_ar').append(slider_html_ar);
            });
            $(document).on('click', '#slider_table_en .add_slider_en', function(){
                var slider_html_en = '';
                slider_html_en += '<tr>';
                slider_html_en += '<td><input type="text" name="en[slider][title][]" class="form-control" /></td>';
                slider_html_en += '<td><input type="text" name="en[slider][desc][]" class="form-control" /></td>';
                slider_html_en += '<td><input type="text" name="en[slider][image][]" class="form-control" /></td>';
                slider_html_en += '<td><input type="text" name="en[slider][link][]" class="form-control" /></td>';
                slider_html_en += '<td><input type="text" name="en[slider][link_text][]" class="form-control" /></td>';
                slider_html_en += '<td><button type="button" class="btn btn-danger btn-sm slider_remove" style="background: red;"><span class="fa fa-minus"></span></button></td></tr>';
                $('#slider_table_en').append(slider_html_en);
            });
            $(document).on('click', '.slider_remove', function(){
                $(this).closest('tr').remove();
            });

            $(document).on('click', '#about_table_ar .add_about_ar', function(){
                var about_html_ar = '';
                about_html_ar += '<tr>';
                about_html_ar += '<td><input type="text" name="ar[about_blocks][title][]" class="form-control" /></td>';
                about_html_ar += '<td><input type="text" name="ar[about_blocks][image][]" class="form-control" /></td>';
                about_html_ar += '<td><button type="button" class="btn btn-danger btn-sm about_remove" style="background: red;"><span class="fa fa-minus"></span></button></td></tr>';
                $('#about_table_ar').append(about_html_ar);
            });
            $(document).on('click', '#about_table_en .add_about_en', function(){
                var about_html_en = '';
                about_html_en += '<tr>';
                about_html_en += '<td><input type="text" name="en[about_blocks][title][]" class="form-control" /></td>';
                about_html_en += '<td><input type="text" name="en[about_blocks][image][]" class="form-control" /></td>';
                about_html_en += '<td><button type="button" class="btn btn-danger btn-sm about_remove" style="background: red;"><span class="fa fa-minus"></span></button></td></tr>';
                $('#about_table_en').append(about_html_en);
            });
            $(document).on('click', '.about_remove', function(){
                $(this).closest('tr').remove();
            });

            $(document).on('click', '#about_sec3_table_ar .add_about_sec3_ar', function(){
                var about_sec3_ar = '';
                about_sec3_ar += '<tr>';
                about_sec3_ar += '<td><input type="text" name="ar[about_sec3][title][]" class="form-control" /></td>';
                about_sec3_ar += '<td><input type="text" name="ar[about_sec3][image][]" class="form-control" /></td>';
                about_sec3_ar += '<td><button type="button" class="btn btn-danger btn-sm about_sec3_remove" style="background: red;"><span class="fa fa-minus"></span></button></td></tr>';
                $('#about_sec3_table_ar').append(about_sec3_ar);
            });
            $(document).on('click', '#about_sec3_table_en .add_about_sec3_en', function(){
                var about_sec3_html_en = '';
                about_sec3_html_en += '<tr>';
                about_sec3_html_en += '<td><input type="text" name="en[about_sec3][title][]" class="form-control" /></td>';
                about_sec3_html_en += '<td><input type="text" name="en[about_sec3][image][]" class="form-control" /></td>';
                about_sec3_html_en += '<td><button type="button" class="btn btn-danger btn-sm about_sec3_remove" style="background: red;"><span class="fa fa-minus"></span></button></td></tr>';
                $('#about_sec3_table_en').append(about_sec3_html_en);
            });
            $(document).on('click', '.about_sec3_remove', function(){
                $(this).closest('tr').remove();
            });

        </script>
    @endsection
    @section('page_title'){{ __('admin/setting.title_tag') }}@endsection
</x-admin-layout>
