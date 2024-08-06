<x-guest-layout>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-10 col-12">
                <div class="AppForm shadow-lg">
                    <div class="row">
                        <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                            <div class="AppFormLeft">
                                <h1>{{ __('front/common.verification_title') }}</h1>

                                @if (session('status') == 'verification-link-sent')
                                    <div class="mb-4 font-medium text-sm text-green-600">
                                        {{ __('front/common.sent') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf

                                    <div>
                                        <x-primary-button class="btn btn-success btn-block shadow border-0 py-2 text-uppercase">
                                            {{ __('front/common.resend') }}
                                        </x-primary-button>
                                    </div>
                                </form>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button type="submit" class="btn btn-success btn-block shadow border-0 py-2 text-uppercase">
                                        {{ __('front/common.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-lg-block d-md-block d-sm-none">
                            <div class="AppFormRight position-relative d-flex justify-content-center flex-column align-items-center text-center p-5 text-white">
                                <h2 class="position-relative px-4 pb-3 mb-4">{{ __('front/common.verification_page') }}</h2>
                                <p>{{ __('front/common.verification_desc') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Session Status -->
    @section('page_title'){{ __('front/common.verification_page') }}@endsection
</x-guest-layout>
