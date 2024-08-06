<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">{{ __('admin/media.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/media.edit.edit') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.media.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/media.show.back') }}</a>
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
                        <h4 class="text-blue h4">{{ __('admin/media.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.media.update', $media->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/media.fields.title') }}</label>
                        <div class="col-sm-12 col-md-12">
                            <input name="name" placeholder="{{ __('admin/media.fields.title') }}" value="{{ $media->name }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>
                            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group row" id="user_image_field_{{$field}}">
                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/media.fields.image') }}</label>
                        <div class="col-sm-6 col-md-6 hidden">
                            <input name="file_name" id="user_image_{{$field}}" placeholder="File Mame" value="{{ $media->file_name }}" class="hidden form-control @error('file_name') border border-danger @enderror" type="text"/>
                            @error('file_name')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-sm-12 col-md-12">
                            {{--@livewire('admin.media-upload')--}}
                            <div class="image_preview" style="float: left; margin-right: 20px;">
                                @if($media->file_name)
                                    <img src="/storage/{{ $media->file_name }}" width="100" />
                                @endif
                            </div>
                            <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field}}" type="button">{{ __('admin/media.fields.media') }}</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-10">
                        <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/media.fields.update') }}</button>
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
    @section('page_title'){{ __('admin/media.edit.title_tag',['media' => $media->name]) }}@endsection
</x-admin-layout>
