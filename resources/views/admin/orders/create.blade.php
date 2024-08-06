<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('admin/order.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/order.create.create') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/order.show.back') }}</a>
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
                        <h4 class="text-blue h4">{{ __('admin/order.create.create') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.orders.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.title') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="title" placeholder="{{ __('admin/order.fields.title') }}" value="{{ old('title') }}" class="main_input border-gray-300 rounded-md shadow-sm form-control @error('title') border border-danger @enderror" type="text"/>
                                    @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/order.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.user_id') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <select name="user_id" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('user_id') border border-danger @enderror">
                                                <option value="" @if(old('user_id') == '') selected @endif>{{ __('admin/order.fields.choose') }}</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" @if(old('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.phone') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="phone" placeholder="{{ __('admin/order.fields.phone') }}" value="{{ old('phone') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('phone') border border-danger @enderror" type="text"/>
                                            @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.tour_id') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <select name="tour_id" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('tour_id') border border-danger @enderror">
                                                <option value="" @if(old('tour_id') == '') selected @endif>{{ __('admin/order.fields.choose') }}</option>
                                                @foreach($tours as $tour)
                                                    <option value="{{ $tour->id }}" @if(old('tour_id') == $tour->id) selected @endif>{{ $tour->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('tour_id')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.amount') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="amount" placeholder="{{ __('admin/order.fields.amount') }}" value="{{ old('amount') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('amount') border border-danger @enderror" type="text"/>
                                            @error('amount')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.content') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <textarea name="content" class="border-gray-300 rounded-md shadow-sm textarea_editor form-control @error('content') border border-danger @enderror">{{ old('content') }}</textarea>
                                            @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.from_place') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="from_place" placeholder="{{ __('admin/order.fields.from_place') }}" value="{{ old('from_place') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('from_place') border border-danger @enderror" type="text"/>
                                            @error('from_place')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.from_date') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="from_date" placeholder="{{ __('admin/order.fields.from_date') }}" value="{{ old('from_date') }}" class="date-picker2 border-gray-300 rounded-md shadow-sm form-control @error('from_date') border border-danger @enderror" type="text"/>
                                            @error('from_date')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.to_place') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="to_place" placeholder="{{ __('admin/order.fields.to_place') }}" value="{{ old('to_place') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('to_place') border border-danger @enderror" type="text"/>
                                            @error('to_place')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.to_date') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="to_date" placeholder="{{ __('admin/order.fields.to_date') }}" value="{{ old('to_date') }}" class="date-picker2 border-gray-300 rounded-md shadow-sm form-control @error('to_date') border border-danger @enderror" type="text"/>
                                            @error('to_date')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">

                            <div class="card card-box custom mb-10" id="accordionOffers">
                                <div class="card-header" data-toggle="collapse" href="#collapseOffers">
                                    <a class="card-title">
                                        {{ __('admin/order.fields.offers') }}
                                    </a>
                                </div>
                                <div id="collapseOffers" class="card-body show pb-0" data-parent="#accordionOffers" aria-expanded="true">

                                    <div class="form-group row" data-select2-id="0">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="offers[]" class="custom-select2 form-control select2-hidden-accessible @error('offers') border border-danger @enderror" multiple="" style="width: 100%">
                                                <optgroup label="{{ __('admin/order.fields.offers') }}">
                                                    @foreach($offers as $offer)
                                                        <option value="{{ $offer->id }}" {{ (old("offers") == $offer->id ? "selected":"") }}>{{ $offer->title }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </div>
                                        @error('offers')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseStatus">
                                    <a class="card-title">
                                        {{ __('admin/order.fields.status') }}
                                    </a>
                                </div>
                                <div id="collapseStatus" class="card-body show" data-parent="#accordionStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('status') border border-danger @enderror">
                                                <option value="" @if(old('status') == '') selected @endif>{{ __('admin/order.fields.choose') }}</option>
                                                <option value="not_payed" @if(old('status') == 'not_payed') selected @endif>{{ __('admin/order.fields.not_payed') }}</option>
                                                <option value="payed" @if(old('status') == 'payed') selected @endif>{{ __('admin/order.fields.payed') }}</option>
                                                <option value="canceled" @if(old('status') == 'canceled') selected @endif>{{ __('admin/order.fields.canceled') }}</option>
                                            </select>
                                            @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/order.fields.create') }}</button>
                        </div>
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
            $(document).ready(function(){
                $('.main_input').focus();
            });
        </script>
    @endsection
    @section('page_title'){{ __('admin/order.create.title_tag') }}@endsection
</x-admin-layout>
