<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\FatoorahServices;
use Illuminate\Support\Facades\Auth;
use function League\Flysystem\toArray;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PaymentController extends Controller
{
    //
    private $fatoorahServices;
    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }

    public function pay(Request $request)
    {
        $user = User::where('id',$request->user)->first();
        if(!empty($user->phone)){
            $phone = $user->phone;
        }else{
            $phone = '';
        }
        if(!empty($user->phone_code)){
            $phone_code = $user->phone_code;
        }else{
            $phone_code = '';
        }
        $data = [
            "CustomerName" => $user->name,
            "NotificationOption"=> "LNK",
            'MobileCountryCode'  => $phone_code,
            'CustomerMobile'     => $phone,
            "InvoiceValue" => $request->totalprice,// total_price
            "CustomerEmail" => $user->email,
            "CallBackUrl"=> route('payment.success'),
            "ErrorUrl"=> route('payment.error'),
            "Language"=> LaravelLocalization::getCurrentLocale(),
            "DisplayCurrencyIso"=>getSetting('currency_iso'),
        ];
        $response = $this->fatoorahServices->sendPayment($data);
        if(isset($response['IsSuccess']))
            if($response['IsSuccess']==true){
                $InvoiceId  = $response['Data']['InvoiceId']; // save this id with your order table
                $InvoiceURL = $response['Data']['InvoiceURL'];
//                dd($InvoiceId,$response,$request->all());
                if(getSetting('payment_getway_st') != 'enabled'){
                $tour = Tour::where('id',$request->tour)->first();
                $order['title'] = '#Order '.$tour->title;
                $order['tour_id'] = $tour->id;
                $order['offers'] = $request->offer;
                $order['user_id'] = $user->id;
                $order['invoice_id'] = $InvoiceId;
                $order['status'] = 'not_payed';
                $order['fin_price'] = $request->totalprice;
                Order::Create($order);
                return redirect()->route('dashboard');// redirect for this link to view payment page
                }
            }
            return redirect($response['Data']['InvoiceURL']);// redirect for this link to view payment page
    }

    public function success(Request $request)
    {
        $postFields = [
            'Key'     => $request->paymentId,
            'KeyType' => 'paymentId'
        ];
        $response = $this->fatoorahServices->getPaymentStatus($postFields);
        //dd($response['Data']['InvoiceId'],$response['Data']['InvoiceReference'],$request->paymentId);
        if($response['IsSuccess'] == true){
            if($response['Data']['InvoiceStatus'] == "Paid"){
                $order = Order::where('invoice_id',$response['Data']['InvoiceId'])->first();
                $order->status = 'payed';
                $order->save();
                return redirect()->route('dashboard')->with([
                    'message' => 'تم الدفع بنجاح',
                    'alert_type' => 'success'
                ]);
            }
        }else{
            return abort(404);
        }
    }

    public function error(Request $request)
    {
        dd($request->Id);
        return 'Error';
    }

}
