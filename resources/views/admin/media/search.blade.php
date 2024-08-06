<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.media.index') }}">{{ __('admin/media.index.title') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/media.index.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.media.index') }}" class="btn btn-primary btn-sm scroll-click">
                        {{ __('admin/media.archive.all') }}</a>
                </div>
            </div>
        </div>
    </x-slot>
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
                <form name="destroy_all" method="post" action="{{route('admin.media.destroy_all')}}" >
                    @csrf
                    <table class="table table nowrap table-bordered table-striped no-footer dtr-inline">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="checkAll"></th>
                            <th scope="col">{{ __('admin/common.table.id')}}</th>
                            <th scope="col">{{ __('admin/common.table.image')}}</th>
                            <th scope="col">{{ __('admin/common.table.acions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($media) > 0)
                            @foreach($media as $med)
                                <tr>
                                    <td scope="row">
                                        <input type="checkbox" name="ids[{{ $med->id }}]" value="{{ $med->id }}">
                                    </td>
                                    <td><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">{{ $med->id }}</span></td>
                                    <td>
                                        <div class="name-avatar d-flex align-items-center">
                                            <div class="avatar mr-2 flex-shrink-0">
                                            <img src="/storage/{{ $med->file_name }}" class="border-radius-100 shadow" width="40" height="40" >
                                            </div>
                                            <div class="txt">
                                                <div class="weight-600">{{ $med->file_name }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="table-actions">
                                            @if(AdminCan('media-edit'))
                                                <a href="{{ route('admin.media.edit',$med->id) }}" data-color="#265ed7" style="color: rgb(38, 94, 215);"><i class="icon-copy dw dw-edit2"></i></a>
                                            @endif
                                            @if(AdminCan('media-delete'))
                                                <a href="{{ route('admin.media.delete',$med->id) }}" data-color="#e95959" style="color: rgb(233, 89, 89);"><i class="icon-copy dw dw-delete-3"></i></a>
                                            @endif
                                            <a href="{{ route('admin.media.show',$med->id) }}" data-color="#265ed7" style="color: rgb(38, 94, 215);"><i class="dw dw-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">{{ __('admin/media.search.notfound') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {!! $media->links() !!}
                    <input class="btn btn-danger hidden destroy_all" type="submit" name="destroy_all" value="{{ __('admin/common.table.delete_selected') }}" style="background:red">
                </form>


            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/media.search.title_tag') }}@endsection
</x-admin-layout>
