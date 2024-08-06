
        @php $field = 'media'; @endphp
        <p class="mt-1 text-sm text-gray-600">
            {{ __("admin/profile.profile_info") }}
        </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('admin/profile.name')" />
            <x-text-input id="name" name="name" type="text" placeholder="{{ __('admin/profile.name') }}" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label class="col-sm-12 col-md-2 col-form-label" for="email" :value="__('admin/profile.email')" />
            <x-text-input id="email" name="email" type="email" placeholder="{{ __('admin/profile.email') }}" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('admin/profile.unverified') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('admin/profile.resend') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('admin/profile.sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-group row" id="user_image_field_{{$field}}">
            <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/profile.image') }}</label>
            <div class="col-sm-6 col-md-6 hidden">
                <input name="image" id="user_image_{{$field}}" placeholder="image" value="{{ old('image', $user->image) }}" class="hidden form-control @error('image') border border-danger @enderror" type="text"/>
                @error('image')<span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="col-sm-12 col-md-10">
                {{--@livewire('admin.media-upload')--}}
                <div class="image_preview" style="float: left; margin-right: 20px;">
                    @if($user->image)
                        <img src="{{ $user->image }}" width="100" />
                    @endif
                </div>
                <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field}}" type="button">{{ __('admin/profile.media') }}</a>
            </div>
        </div>



        <div>
            <x-input-label for="dob" :value="__('admin/profile.dob')" />
            <x-text-input id="dob" name="dob" type="text" class="date-picker2 mt-1 block w-full" placeholder="{{ __('admin/profile.dob') }}" :value="old('dob', $user->dob)" required autofocus autocomplete="dob" />
            <x-input-error class="mt-2" :messages="$errors->get('dob')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('admin/profile.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('admin/profile.saved') }}</p>
            @endif
        </div>
    </form>

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
