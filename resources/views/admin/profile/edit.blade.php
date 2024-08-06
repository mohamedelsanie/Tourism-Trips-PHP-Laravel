<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/profile.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/profile.edit') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                @include('admin.profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/profile.update_pass') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                @include('admin.profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/profile.delete') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                    @include('admin.profile.partials.delete-user-form')
            </div>
        </div>
    </div>
    @section('page_title'){{ __('admin/profile.title_tag') }}@endsection

</x-admin-layout>
