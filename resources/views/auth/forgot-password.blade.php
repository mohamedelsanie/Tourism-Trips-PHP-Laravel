<x-guest-layout>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-10 col-12">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                            <div class="AppFormLeft">
                                <h1>{{ __('front/common.forget_password') }}</h1>
                                <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <!-- Email Address -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="email" :value="__('front/common.email')" />
                                        <x-text-input id="email" placeholder="{{ __('front/common.email') }}" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none" type="email" name="email" :value="old('email')" required autofocus />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                        <i class="fa fa-user-o"></i>
                                    </div>

                                    <x-primary-button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase">
                                        {{ __('front/common.email_prl') }}
                                    </x-primary-button>

                                </form>
                                <p class="text-center mt-5">
                                    <span>
                                    <a href="{{ route('login') }}">{{ __('front/common.back_login') }}</a>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-lg-block d-md-block d-sm-none">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">{{ __('front/common.forget_password') }}</h2>
                                <p>{{ __('front/common.forget_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Session Status -->
    @section('page_title'){{ __('front/common.forget_page') }}@endsection
</x-guest-layout>
