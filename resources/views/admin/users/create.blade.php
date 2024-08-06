<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">{{ __('admin/user.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/user.create.create') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/user.show.back') }}</a>
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
                        <h4 class="text-blue h4">{{ __('admin/user.create.create') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.users.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.name') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="name" placeholder="{{ __('admin/user.fields.name') }}" value="{{ old('name') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>
                                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.email') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="email" placeholder="{{ __('admin/user.fields.email') }}" value="{{ old('email') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('email') border border-danger @enderror" type="email" />
                                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.password') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="password" placeholder="************" value="{{ old('password') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('password') border border-danger @enderror" type="password" />
                                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/user.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.dob') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="dob" placeholder="{{ __('admin/user.fields.dob') }}" value="{{ old('dob') }}" class="border-gray-300 rounded-md shadow-sm date-picker2 form-control @error('dob') border border-danger @enderror" type="text"/>
                                            @error('dob')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.phone_code') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="phone_code" placeholder="{{ __('admin/user.fields.phone_code') }}" value="{{ old('phone_code') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('phone_code') border border-danger @enderror" type="text"/>
                                            @error('phone_code')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.phone') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="phone" placeholder="{{ __('admin/user.fields.phone') }}" value="{{ old('phone') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('phone') border border-danger @enderror" type="text"/>
                                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/user.fields.quaote') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <textarea name="quaote" class="border-gray-300 rounded-md shadow-sm textarea_editor form-control @error('quaote') border border-danger @enderror">{{ old('quaote') }}</textarea>
                                            @error('quaote')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box custom mb-10" id="accordionImage">
                                <div class="card-header" data-toggle="collapse" href="#collapseImage">
                                    <a class="card-title">
                                        {{ __('admin/user.fields.image') }}
                                    </a>
                                </div>
                                <div id="collapseImage" class="card-body show pb-0" data-parent="#accordionImage" aria-expanded="true">
                                    <div class="form-group row" id="user_image_field_{{$field}}">
                                        <div class="col-sm-6 col-md-6 hidden">
                                            <input name="image" id="user_image_{{$field}}" placeholder="image" value="{{ old('image') }}" class="hidden form-control @error('image') border border-danger @enderror" type="text"/>
                                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            {{--@livewire('admin.media-upload')--}}
                                            <div class="image_preview" style="float: left; margin-right: 20px;"></div>
                                            <div class="clearfix"></div>
                                            <div class="block">
                                                <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field}}" type="button">{{ __('admin/user.fields.media') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseStatus">
                                    <a class="card-title">
                                        {{ __('admin/user.fields.status') }}
                                    </a>
                                </div>
                                <div id="collapseStatus" class="card-body show" data-parent="#accordionStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('status') border border-danger @enderror">
                                                <option value="" @if(old('status') == '') selected @endif>{{ __('admin/user.fields.choose') }}</option>
                                                <option value="published" @if(old('status') == 'published') selected @endif>{{ __('admin/user.fields.published') }}</option>
                                                <option value="disabled" @if(old('status') == 'disabled') selected @endif>{{ __('admin/user.fields.disabled') }}</option>
                                            </select>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/user.fields.create') }}</button>
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

            $("#mode_type").change(function() {
                if ($(this).val() === 'super'){
                    $('.exp_date').show();
                } else {
                    $('.exp_date').hide();
                }
            });
        </script>
    @endsection
    @section('page_title'){{ __('admin/user.create.title_tag') }}@endsection
</x-admin-layout>
