<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">{{ __('admin/order.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/order.show.title',['title' => $order->title]) }}</li>
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

                            <div class="form-group col-sm-12 col-md-12">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.title') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <p>{{ $order->title }}</p>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-12">
                            <div class="card card-box custom mb-10 " id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/order.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.user_id') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <p>{{ $user->name }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.phone') }}</label>
                                        <p>{{ $order->phone }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.tour_id') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <p>{{ $tour->title }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.amount') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <p>{{ $order->fin_price }}</p>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.content') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                        <p>{{ $order->content }}</p>
                                    </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.from_place') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                        <p>{{ $order->from_place }}</p>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.from_date') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                        <p>{{ $order->from_date }}</p>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.to_place') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                        <p>{{ $order->to_place }}</p>
                                    </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.to_date') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                        <p>{{ $order->to_date }}</p>
                                    </div>
                                    </div>
                                    @if(!empty($order->offers))
                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.offers') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                         @foreach($offers as $offer)
                                         @if(in_array($offer->id,$order->offers))
                                         <p>{{ $offer->title }}</p>
                                         @endif
                                        @endforeach
                                    </div>
                                    </div>
                                     @endif

                                    <div class="form-group">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/order.fields.status') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                         @if($order->status == 'not_payed')
                                         <p>{{ __('admin/order.fields.not_payed') }}</p>
                                         @elseif($order->status == 'payed')
                                         <p>{{ __('admin/order.fields.payed') }}</p>
                                         @else
                                         <p>{{ __('admin/order.fields.canceled') }}</p>
                                         @endif
                                    </div>
                                    </div>

                                </div>

                            </div>
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
