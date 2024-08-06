<x-app-layout>
    <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url({{ asset('assets/front/img/bg-img/17.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcrumb-content text-center">
                        <h2 class="page-title">{{ __('front/profile.dashboard') }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="index-2.html">{{ __('front/common.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('front/profile.dashboard') }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--@include('layouts.navigation')--}}

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                    <table class="table table nowrap table-bordered table-striped no-footer dtr-inline">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __('front/profile.order.date')}}</th>
                            <th scope="col">{{ __('front/profile.order.title')}}</th>
                            <th scope="col">{{ __('front/profile.order.amount')}}</th>
                            <th scope="col">{{ __('front/profile.order.status')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($orders) > 0)
                            @php $counter = 1 ; @endphp
                            @foreach($orders as $order)
                                <tr>
                                    <td scope="row" class="col-md-1">
                                        # {{ $counter }}
                                    </td>
                                    <td width="40" class="col-md-2">
                                        <div class="txt"><div class="weight-600">{{ $order->created_at->format('Y-m-d') }}</div></div>
                                    </td>
                                    <td class="col-md-6">
                                        <div class="name-avatar d-flex align-items-center">
                                            <div class="txt">
                                                <div class="weight-600"><a href="{{ getTourLink($order->tour->slug) }}">{{ $order->title }}</a></div>
                                                @if($order->offers)
                                                    <span>{{ __('front/profile.order.offers') }}<br /></span>
                                                    @if(count($order->offers) > 0)
                                                        @foreach($order->offers as $offer)
                                                            @php $offers = \App\Models\Offer::where('id',$offer)->get(); @endphp
                                                            @if(count($offers) > 0)
                                                                @foreach($offers as $off)
                                                                    <span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">
                                                                    {{ $off->title }}
                                                                    </span><br />
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-md-2">{{ getPrice($order->fin_price) }}</td>
                                    <td class="col-md-1"><span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">
                                            @if($order->status == 'not_payed')
                                                {{ __('front/profile.order.not_payed') }}
                                            @elseif($order->status == 'payed')
                                                {{ __('front/profile.order.payed') }}
                                            @elseif($order->status == 'canceled')
                                                {{ __('front/profile.order.canceled') }}
                                            @endif
                                        </span></td>
                                </tr>
                                @php $counter++ ; @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">{{ __('front/profile.order.notfound') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    {!! $orders->links() !!}
            </div>
        </div>
    </div>
    @section('page_title'){{ __('front/profile.dashboard') }}@endsection
</x-app-layout>
