<div>
        <div class="col-md-12" wire:submit.prevent="refresh" >
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @auth
    <p>{{ __('front/profile.clickto_checkout') }}</p>
    <script>
        $("#checkOut .modal-footer").removeClass('hidden');
    </script>
    <input type="hidden" name="user" value="@auth{{ Auth::user()->id }}@endif" />

    <div class="modal-footer hidden">
        <button type="submit" class="btn btn-primary">{{ __('front/profile.checkout') }}</button>
    </div>
    @else
        @if($registerForm)
            <form method="POST"  wire:submit.prevent="refresh">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.name') }} :</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.email') }} :</label>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.phone_code') }} :</label>
                        <input type="text" wire:model="phone_code" value="002" class="form-control">
                        @error('phone_code') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.phone') }} :</label>
                        <input type="text" wire:model="phone" class="form-control">
                        @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.password') }} :</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn text-white btn-success" wire:click.prevent="registerStore">{{ __('front/common.register_title') }}</button>
                </div>

                <br />
                <div class="col-md-12">
                    {{ __('front/common.already_registered') }} <a class="btn btn-primary text-white" wire:click.prevent="register"><strong>{{ __('front/common.login') }}</strong></a>
                </div>
            </form>
        @else
            <form method="POST"  wire:submit.prevent="refresh">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.email') }} :</label>
                        <input type="text" wire:model="email" class="form-control">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('front/common.password') }} :</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn text-white btn-success" wire:click.prevent="login">{{ __('front/common.login') }}</button>
                </div>
                <br />
                <div class="col-md-12">
                    {{ __('front/common.have_account') }} <a class="btn btn-primary text-white" wire:click.prevent="register"><strong>{{ __('front/common.register_title') }}</strong></a>
                </div>
            </form>
        @endif
    @endif
</div>