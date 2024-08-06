<x-guest-layout>

    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-10 col-12">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                            <div class="AppFormLeft">
                                <h1>{{ __('front/common.register_title') }}</h1>
                                <form method="POST" action="{{ route('register') }}">
                                @csrf
                                    <!-- Name -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="name" :value="__('front/common.name')" />
                                        <x-text-input id="name" placeholder="{{ __('front/common.name') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" type="text" name="name" :value="old('name')" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                        <i class="fa fa-user-o"></i>
                                    </div>

                                    <!-- Email Address -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="email" :value="__('front/common.email')" />
                                        <x-text-input id="email" placeholder="{{ __('front/common.email') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" type="email" name="email" :value="old('email')" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        <i class="fa fa-user-o"></i>
                                    </div>

                                    <!-- Name -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="phone_code" :value="__('front/common.phone_code')" />
                                        <x-text-input id="phone_code" placeholder="{{ __('front/common.phone_code') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" type="text" name="phone_code" :value="old('phone_code')" required />
                                        <x-input-error :messages="$errors->get('phone_code')" class="mt-2" />
                                        <i class="fa fa-user-o"></i>
                                    </div>

                                    <!-- Name -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="phone" :value="__('front/common.phone')" />
                                        <x-text-input id="phone" placeholder="{{ __('front/common.phone') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" type="text" name="phone" :value="old('phone')" required />
                                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                        <i class="fa fa-user-o"></i>
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="password" :value="__('front/common.password')" />

                                        <x-text-input id="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none"
                                                      type="password"
                                                      name="password"
                                                      placeholder="{{ __('front/common.password') }}"
                                                      required autocomplete="new-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <i class="fa fa-key"></i>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="password_confirmation" :value="__('front/common.confirm_password')" />

                                        <x-text-input id="password_confirmation" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none"
                                                      type="password"
                                                      placeholder="{{ __('front/common.confirm_password') }}"
                                                      name="password_confirmation" required />

                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        <i class="fa fa-key"></i>
                                    </div>


                                    <x-primary-button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase">
                                        {{ __('front/common.register') }}
                                    </x-primary-button>
                                </form>
                                <p class="text-center mt-5">

                                    <span>
                                    <a href="{{ route('login') }}">{{ __('front/common.already_registered') }}</a>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-lg-block d-md-block d-sm-none">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">{{ __('front/common.register_page') }}</h2>
                                <p>{{ __('front/common.register_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Session Status -->
    @section('page_title'){{ __('front/common.register_page') }}@endsection
</x-guest-layout>
