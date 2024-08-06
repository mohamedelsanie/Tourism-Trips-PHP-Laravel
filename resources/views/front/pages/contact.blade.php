
<section class="google-maps-contact-info">
    <div class="container-fluid">
        <div class="google-maps-contact-content">
            <div class="row">

                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        <h4>{{ __('front/post_types.page.contact_phone') }}</h4>
                        <p>{{ getSetting('phone') }}</p>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <h4>{{ __('front/post_types.page.contact_adress') }}</h4>
                        <p>{{ getSetting('footer_adress') }}</p>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <h4>{{ __('front/post_types.page.contact_times') }}</h4>
                        <p>{{ getSetting('contact_opening') }}</p>
                    </div>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="single-contact-info">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <h4>{{ __('front/post_types.page.contact_email') }}</h4>
                        <p>{{ getSetting('email') }}</p>
                    </div>
                </div>
            </div>

            <div class="google-maps">
                <iframe src="{{ getSetting('map_link') }}" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>

<div class="roberto-contact-form-area section-padding-100">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="section-heading text-center wow fadeInUp" data-wow-delay="100ms">
                    <h6>{{ $page->title }}</h6>
                    <h2>{{ __('front/post_types.page.contact_send_leave') }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <div class="roberto-contact-form">
                    <form action="{{ route('sendmessage') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6 wow fadeInUp" data-wow-delay="100ms">
                                @auth()
                                <input type="text" name="name" value="{{ old('name') ? old('name') : auth()->user()->name }}" class="form-control mb-30 @error('name') border border-danger @enderror" placeholder="{{ __('front/post_types.page.contact_send_name') }}">
                                @else
                                <input type="text" name="name" value="{{ old('name') ? old('name') : '' }}" class="form-control mb-30 @error('name') border border-danger @enderror" placeholder="{{ __('front/post_types.page.contact_send_name') }}">
                                @endif
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-12 col-lg-6 wow fadeInUp" data-wow-delay="100ms @error('email') border border-danger @enderror">
                                @auth()
                                <input type="email" name="email" value="{{ old('email') ? old('email') : auth()->user()->email }}" class="form-control mb-30" placeholder="{{ __('front/post_types.page.contact_send_email') }}">
                                @else
                                <input type="email" name="email" value="{{ old('email') ? old('email') : '' }}" class="form-control mb-30" placeholder="{{ __('front/post_types.page.contact_send_email') }}">
                                @endif
                                @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-12 col-lg-12 wow fadeInUp" data-wow-delay="100ms @error('subject') border border-danger @enderror">
                                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control mb-30" placeholder="{{ __('front/post_types.page.contact_send_subject') }}">
                                @error('subject')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-12 wow fadeInUp" data-wow-delay="100ms">
                                <textarea name="message" value="{{ old('message') }}" class="form-control mb-30 @error('message') border border-danger @enderror" placeholder="{{ __('front/post_types.page.contact_send_message') }}"></textarea>
                                @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-12 text-center wow fadeInUp" data-wow-delay="100ms">
                                <button type="submit" class="btn roberto-btn mt-15">{{ __('front/post_types.page.contact_send_post') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>