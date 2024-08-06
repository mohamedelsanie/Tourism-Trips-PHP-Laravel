<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">{{ __('admin/permission.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/permission.create.create') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/permission.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/permission.create.create') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.permissions.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/permission.fields.title') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <input name="title" placeholder="{{ __('admin/permission.fields.title') }}" value="{{ old('title') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('title') border border-danger @enderror" type="text"/>
                            @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/permission.fields.name') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <input name="name" placeholder="{{ __('admin/permission.fields.name') }}" value="{{ old('name') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/permission.fields.create') }}</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/permission.create.title_tag') }}@endsection
</x-admin-layout>
