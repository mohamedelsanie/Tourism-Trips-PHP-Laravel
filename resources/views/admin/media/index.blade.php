<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/media.index.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    @if(AdminCan('media-create'))
                    <a data-toggle="modal" data-target=".media_uploader" class="btn btn-primary btn-sm scroll-click"><i class="fa fa-plus"></i>{{ __('admin/media.index.create') }}</a>
                    @endif
                    @if(AdminCan('media-forcedelete'))
                    <a href="{{ route('admin.media.archive') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/media.index.archive') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
    @php $field = 'media'; @endphp
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 mb-0">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="clearfix mb-10">
                            <div class="pull-left">
                                <h4 class="text-blue h4">{{ __('admin/media.index.title') }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">

                        <form name="search_form" method="post" action="{{route('admin.media.search')}}" >
                            @csrf
                            <div class="input-group">
                                <div class="input-group-addon"><i class="glyphicon glyphicon-search"></i></div>
                                <input name="search" type="text" value="{{ request('search') }}" class="form-control border-gray-300 rounded-md shadow-sm" id="search" placeholder="{{__('admin/common.table.search_placeholder')}}" />
                                <div class="text-right">
                                    <button class="btn btn-primary border-gray-300 rounded-md shadow-sm" type="submit" style="background:blue">{{__('admin/common.table.search_button')}}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <livewire:admin.media-index />
                {{--    {{ $field }}--}}
                @if(AdminCan('media-create'))
                <div class="modal fade bs-example-modal-lg media_uploader"  wire:ignore.self id="bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="media_model" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-titl media_model" id="">
                                    {{ __('admin/media.index.create') }}
                                </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    ×
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="user_image_modal">
                                    <livewire:admin.file-uploader :field="$field" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">--}}
                                {{--Close--}}
                                {{--</button>--}}
                                <button type="button" data-dismiss="modal" class="use_image btn btn-primary">
                                    {{ __('admin/media.index.close') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @section('page_title'){{ "- Media" }}@endsection
</x-admin-layout>
