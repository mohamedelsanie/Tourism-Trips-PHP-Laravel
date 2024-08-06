<div>
    <form  wire:submit.prevent="save" enctype="multipart/form-data">

        @if (session()->has('message'))
            <div class="alert alert-success alert_session alert_uploaded_{{$field}}" id="alert_uploaded_{{$field}}">
                {{ session('message') }}
                <img src="/storage/{{ session('image') }}" width="100" />
            </div>
        @endif

            @if (session()->has('image') || !empty(session()->has('image')))
                <script>
                    $('.media_uploader_{{$field}} button.use_image').click(function(){
                        $('#user_image_{{$field}}').val('/storage/{{ session('image') }}');
                        var value = $("#user_image_{{$field}}").val();
                        $("#user_image_field_{{$field}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                        $('#alert_uploaded_{{$field}}').fadeTo(3000,300).slideUp(300,function () {
                            $(this).slideUp(300);
                        });
                    });


                </script>
                {{--{{ session('message') }}--}}
            @endif


            <div class="file-upload">
                {{--<button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>--}}

                <div class="image-upload-wrap">
                    <input class="file-upload-input" type="file" accept="image/*" wire:model="photo" />
                    {{--<input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />--}}
                    <div class="drag-text">
                        <h3>{{ __('admin/media.box.drag') }}</h3>
                        <div wire:loading wire:target="photo"><i class="fa fa-spinner fa-spin text-2x1"></i>  {{ __('admin/media.box.uploading') }}</div>
                    </div>
                </div>



                @if ($photo)
                    <div class="file-upload-content">
                        <img class="file-upload-image" src="{{ $photo->temporaryUrl() }}" alt="your image" />
                        <div class="image-title-wrap">
                            <a  wire:click="remove" class="remove-image">{{ __('admin/media.box.remove') }} <div wire:loading wire:target="remove"><i class="fa fa-spinner fa-spin text-2x1"></i>  {{ __('admin/media.box.loading') }}</div></a>
                            <button wire:loading.remove wire:click.prevent="save" class="save-image" type="button">{{ __('admin/media.box.save') }} <div wire:loading wire:target="save"><i class="fa fa-spinner fa-spin text-2x1"></i>  {{ __('admin/media.box.loading') }}</div></button>
                            {{--<button wire:loading wire:target="save" type="button">--}}
                                {{--<i class="fa fa-spinner fa-spin text-2x1"></i>--}}
                            {{--</button>--}}
                        </div>
                    </div>

                @endif
            </div>
            {{--<input type="file" accept="image/*" wire:model="photo" />--}}
        @error('photo') <span class="error">{{ $message }}</span> @enderror

            @if ($photo)
            @endif

    </form>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
</div>

