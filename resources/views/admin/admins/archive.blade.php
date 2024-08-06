<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.admins.index') }}">{{ __('admin/admin.index.title') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/admin.archive.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-primary btn-sm scroll-click">
                        {{ __('admin/admin.archive.all') }}</a>
                </div>
            </div>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="clearfix mb-10">
                            <div class="pull-left">
                                <h4 class="text-blue h4">{{ __('admin/admin.archive.title') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <form name="restore_all" method="post" action="{{route('admin.admins.restore_all')}}" >
                    @csrf
                    <table class="table table nowrap table-bordered table-striped no-footer dtr-inline">
                        <thead>
                        <tr>
                            <th scope="col"><input type="checkbox" id="checkAll"></th>
                            <th scope="col">{{ __('admin/common.table.name') }}</th>
                            <th scope="col">{{ __('admin/common.table.email') }}</th>
                            <th scope="col">{{ __('admin/common.table.role') }}</th>
                            <th scope="col">{{ __('admin/common.table.acions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($admins) > 0)
                            @foreach($admins as $admin)
                                <tr>
                                    <td scope="row">
                                        <input type="checkbox" name="ids[{{ $admin->id }}]" value="{{ $admin->id }}">
                                    </td>
                                    <td>
                                        <div class="name-avatar d-flex align-items-center">
                                            <div class="txt">
                                                <div class="weight-600">{{ $admin->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">{{ $admin->getRoleNames() }}</span>

                                    <td>
                                        <div class="table-actions">
                                            @if(AdminCan('admin-forcedelete'))
                                                <a href="{{ route('admin.admins.delete',$admin->id) }}" data-color="#e95959" style="color: rgb(233, 89, 89);"><i class="icon-copy dw dw-delete-3"></i></a>
                                                <a href="{{ route('admin.admins.restore',$admin->id) }}" data-color="#265ed7"><i class="icon-copy dw dw-cursor-1"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">{{ __('admin/admin.archive.notfound') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {!! $admins->links() !!}
                    <input class="btn btn-primary hidden destroy_all" type="submit" name="restore_all" value="{{ __('admin/common.table.restore_selected') }}" style="background:blue">
                </form>


            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/admin.archive.title_tag') }}@endsection
</x-admin-layout>
