<x-guest-layout>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-10 col-12">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                            <div class="AppFormLeft">
                                <h1>{{ __('front/common.login_page') }}</h1>

                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                @if(session('message'))
                                    <br>
                                    <div class="alert alert-{{ session('alert_type') }} alert-dismissible fade show" role="alert" id="alert_session">
                                        {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <!-- Email Address -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="email" :value="__('front/common.email')" />
                                        <x-text-input id="email" placeholder="{{ __('front/common.email') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" type="email" name="email" :value="old('email')" required autofocus />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        <i class="fa fa-user-o"></i>
                                    </div>
                                    <!-- Password -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="password" :value="__('front/common.password')" />

                                        <x-text-input id="password" placeholder="{{ __('front/common.password') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none"
                                                      type="password"
                                                      name="password"
                                                      required autocomplete="current-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <i class="fa fa-key"></i>
                                    </div>

                                    <div class="row  mt-4 mb-4">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <label for="remember_me" class="inline-flex items-center">
                                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                    <span class="ml-2 text-sm text-gray-600">{{ __('front/common.remember') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            @if (Route::has('password.request'))
                                                <a class="" href="{{ route('password.request') }}">
                                                    {{ __('front/common.forgot') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <x-primary-button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase">
                                        {{ __('front/common.login') }}
                                    </x-primary-button>
                                </form>
                                <p class="text-center mt-5">
                                    {{ __('front/common.have_account') }}
                                    <span>
                                    <a href="{{ route('register') }}">{{ __('front/common.create_account') }}</a>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-lg-block d-md-block d-sm-none">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">{{ __('front/common.login') }}</h2>
                                <p>{{ __('front/common.login_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Session Status -->
    @section('page_title'){{ __('front/common.login_page') }}@endsection
</x-guest-layout>
