<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ __('admin/role.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/role.edit.edit') }}<code>{{ $role->name }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/role.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/role.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/role.fields.title') }}</label>
                        <div class="col-sm-12 col-md-12">
                            <input name="name" placeholder="{{ __('admin/role.fields.title') }}" value="{{ $role->name }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/role.fields.permissions') }}</label>
                        <div class="col-sm-12 col-md-12">

                            <select name="permission[]" class="selectpicker form-control @error('permission') border border-danger @enderror border-gray-300 rounded-md shadow-sm" data-size="5" data-style="border-gray-300" multiple data-actions-box="true" data-selected-text-format="count">
                                @foreach($permissions  as $key => $permission)
                                    <option value="{{ $permission->id }}" @if(in_array($permission->id, $rolePermissions)) selected @endif>{{ $permission->title }}</option>
                                @endforeach

                            </select>
                            @error('permission')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/role.fields.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/role.edit.title_tag',['role' => $role->name]) }}@endsection
</x-admin-layout>
