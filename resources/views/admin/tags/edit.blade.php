<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">{{ __('admin/tag.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/tag.edit.edit') }}<code>{{ $tag->title }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/tag.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/tag.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.tags.update', $tag->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/tag.fields.title') }}</label>
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
                                        <input name="{{ $key }}[title]" placeholder="{{ __('admin/tag.fields.title') }}" value="{{ $tag->translate($key)->title }}" class="@if(LaravelLocalization::getCurrentLocale() == $key) slug-input main_input @endif border-gray-300 rounded-md shadow-sm form-control @if($errors->has($key.'*title')) border border-danger @endif" type="text"/>
                                        @if($errors->has($key.'*title'))<span class="text-danger">{{ $errors->first($key.'*title') }}</span>@endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/tag.fields.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/tag.edit.title_tag',['tag' => $tag->title]) }}@endsection
</x-admin-layout>
