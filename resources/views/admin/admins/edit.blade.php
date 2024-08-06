<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">{{ __('admin/admin.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/admin.edit.edit') }}<code>{{ $admin->name }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/admin.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>
    @php $field = 'media'; @endphp
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/admin.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.admins.update', $admin->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/admin.fields.name') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="name" placeholder="{{ __('admin/admin.fields.name') }}" value="{{ $admin->name }}" class="form-control @error('name') border border-danger @enderror" type="text"/>
                                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/admin.fields.email') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="email" placeholder="{{ __('admin/admin.fields.email') }}" value="{{ $admin->email }}" class="form-control @error('email') border border-danger @enderror" type="email" />
                                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/admin.fields.password') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="edit_password" placeholder="{{ __('admin/admin.fields.password') }}" class="form-control @error('password') border border-danger @enderror" type="password" />
                                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/admin.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/admin.fields.dob') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="dob" placeholder="{{ __('admin/admin.fields.dob') }}" value="{{ $admin->dob }}" class="border-gray-300 rounded-md shadow-sm date-picker2 form-control @error('dob') border border-danger @enderror" type="text"/>
                                            @error('dob')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box custom mb-10" id="accordionImage">
                                <div class="card-header" data-toggle="collapse" href="#collapseImage">
                                    <a class="card-title">
                                        {{ __('admin/admin.fields.image') }}
                                    </a>
                                </div>
                                <div id="collapseImage" class="card-body show pb-0" data-parent="#accordionImage" aria-expanded="true">

                                    <div class="form-group row" id="user_image_field_{{$field}}">
                                        <div class="col-sm-6 col-md-6 hidden">
                                            <input name="image" id="user_image_{{$field}}" placeholder="image" value="{{ $admin->image }}" class="hidden form-control @error('image') border border-danger @enderror" type="text"/>
                                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            {{--@livewire('admin.media-upload')--}}
                                            <div class="image_preview" style="float: left; margin-right: 20px;">
                                                @if($admin->image)
                                                    <img src="{{ $admin->image }}" width="100" />
                                                @endif
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="block">
                                                <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field}}" type="button">{{ __('admin/admin.fields.media') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseStatus">
                                    <a class="card-title">
                                        {{ __('admin/admin.fields.status') }}
                                    </a>
                                </div>
                                <div id="collapseStatus" class="card-body show" data-parent="#accordionStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('status') border border-danger @enderror">
                                                @if($admin->status == 'published')
                                                    <option value="published" selected>{{ __('admin/admin.fields.published') }}</option>
                                                    <option value="disabled">{{ __('admin/admin.fields.disabled') }}</option>
                                                @elseif($admin->status == 'disabled')
                                                    <option value="published">{{ __('admin/admin.fields.published') }}</option>
                                                    <option value="disabled" selected>{{ __('admin/admin.fields.disabled') }}</option>
                                                @else
                                                    <option selected="">Choose...</option>
                                                    <option value="published">{{ __('admin/admin.fields.published') }}</option>
                                                    <option value="disabled">{{ __('admin/admin.fields.disabled') }}</option>
                                                @endif
                                            </select>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionRole">
                                <div class="card-header" data-toggle="collapse" href="#collapseRole">
                                    <a class="card-title">
                                        {{ __('admin/admin.fields.role') }}
                                    </a>
                                </div>
                                <div id="collapseRole" class="card-body show" data-parent="#accordionRole" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="roles" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('status') border border-danger @enderror">
                                                <option value="">{{ __('admin/admin.fields.choose') }}</option>
                                                @if($roles)
                                                    @foreach($roles as $key => $role)

                                                        <option value="{{ $role }}" @if($key == array_keys($admin_role)[0]) selected @endif>{{ $role }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/admin.fields.update') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div id="user_image_modal_{{$field}}">
        <livewire:admin.media-box :field="$field" />
    </div>


    @section('scripts')
        <script>
            $('#user_image_modal_{{$field}} #gallery_{{$field}} a.image_ch').click(function(){
                $('#user_image_field_{{$field}} #user_image_{{$field}}').val($(this).data('image'));
                var value = $("#user_image_{{$field}}").val();
                $("#user_image_field_{{$field}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field}} #user_image_{{$field}}').val('');
                    $("#user_image_field_{{$field}} .image_preview a.remove_img").remove();
                });
                //$('.media_uploader').modal('hide');
            });
        </script>
    @endsection
    @section('page_title'){{  __('admin/admin.edit.title_tag',['admin' => $admin->name]) }}@endsection
</x-admin-layout>
