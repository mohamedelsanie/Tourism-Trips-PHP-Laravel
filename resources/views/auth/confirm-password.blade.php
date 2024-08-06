<x-guest-layout>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-10 col-12">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                            <div class="AppFormLeft">
                                <h1>{{ __('front/common.confirm_password') }}</h1>
                                <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <!-- Password -->
                                    <div class="form-group position-relative mb-4">
                                        <x-input-label for="password" :value="__('front/common.password')" />

                                        <x-text-input id="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none"
                                                      type="password"
                                                      name="password"
                                                      placeholder="{{ __('front/common.password') }}"
                                                      required autocomplete="current-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        <i class="fa fa-key"></i>
                                    </div>

                                    <x-primary-button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase">
                                        {{ route('password.confirm') }}
                                    </x-primary-button>

                                </form>
                                <p class="text-center mt-5">
                                    <span>
                                    <a href="{{ route('login') }}">{{ __('Back To Login') }}</a>
                                </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-lg-block d-md-block d-sm-none">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">{{ __('front/common.confirm_password') }}</h2>
                                <p>{{ __('front/common.confirm_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Session Status -->
    @section('page_title'){{ __('front/common.confirm_password') }}@endsection
</x-guest-layout>
