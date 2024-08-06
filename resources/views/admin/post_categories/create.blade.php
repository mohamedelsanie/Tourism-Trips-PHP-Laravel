<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">{{ __('admin/category.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/category.create.create') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/category.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/category.create.create') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.categories.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/category.fields.title') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @foreach(config('translatable.languages') as $key => $lang)
                                            <li class="nav-item @if($errors->has($key.'*title'))  border border-danger @endif">
                                                <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#title-{{ $key }}" role="tab">{{ $lang }}</a>
                                            </li>
                                        @endforeach
                                    </ul><!-- Tab panes -->
                                    <div class="tab-content">
                                        @foreach(config('translatable.languages') as $key => $lang)
                                            <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="title-{{ $key }}" role="tabpanel">
                                                <input name="{{ $key }}[title]" placeholder="{{ __('admin/category.fields.title') }}" value="{{ old($key.'.title') }}" class="@if(LaravelLocalization::getCurrentLocale() == $key) slug-input main_input @endif border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*title')) border border-danger @endif" type="text"/>
                                                @if($errors->has($key.'*title'))<span class="text-danger">{{ $errors->first($key.'*title') }}</span>@endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/category.fields.slug') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="slug" placeholder="{{ __('admin/category.fields.slug') }}" value="{{ old('slug') }}" class="slug-output border-gray-300 rounded-md shadow-sm form-control @error('slug') border border-danger @enderror" type="text"/>
                                    @error('slug')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/category.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/category.fields.description') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <ul class="nav nav-tabs" role="tablist">
                                                @foreach(config('translatable.languages') as $key => $lang)
                                                    <li class="nav-item @if($errors->has($key.'*description'))  border border-danger @endif">
                                                        <a class="nav-link @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" data-toggle="tab" href="#description-{{ $key }}" role="tab">{{ $lang }}</a>
                                                    </li>
                                                @endforeach
                                            </ul><!-- Tab panes -->
                                            <div class="tab-content">
                                                @foreach(config('translatable.languages') as $key => $lang)
                                                    <div class="tab-pane @if(LaravelLocalization::getCurrentLocale() == $key) active @endif" id="description-{{ $key }}" role="tabpanel">
                                                        <textarea name="{{ $key }}[description]" placeholder="{{ __('admin/category.fields.description') }}" class="border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*description')) border border-danger @endif">{{ old($key.'.description') }}</textarea>
                                                        @if($errors->has($key.'*description'))<span class="text-danger">{{ $errors->first($key.'*description') }}</span>@endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box custom mb-10" id="accordionParent">
                                <div class="card-header" data-toggle="collapse" href="#collapseParent">
                                    <a class="card-title">
                                        {{ __('admin/category.fields.parent') }}
                                    </a>
                                </div>
                                <div id="collapseParent" class="card-body show" data-parent="#accordionParent" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="parent" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('parent') border border-danger @enderror">
                                                <option value="0" @if(old('parent') == '0') selected @endif>{{ __('admin/category.fields.main') }}</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" @if($category->id == old('parent')) selected @endif>{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('parent')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/category.fields.create') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function(){
                @if(LaravelLocalization::getCurrentLocale() == $key)
                $('.main_input').focus();
                        @endif
                var slug = function(str) {
                        var $slug = '';
                        var trimmed = $.trim(str);
                        //replace all special characters | symbols with a space
                        $slug = trimmed.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
                        // trim spaces at start and end of string
                            .replace(/^\s+|\s+$/gm,'')
                            // replace space with dash/hyphen
                            .replace(/\s+/g, '-');
                        return $slug.toLowerCase();
                    };

                $('.slug-input').keyup(function() {
                    var takedata = $('.slug-input').val();
                    $('.slug-output').val(slug(takedata));
                });
            });
        </script>
    @endsection
    @section('page_title'){{ __('admin/category.create.title_tag') }}@endsection
</x-admin-layout>
