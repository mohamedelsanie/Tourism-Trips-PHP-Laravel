<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\News;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index()
    {
//        dd(\Auth::guard('admin')->user()->hasRole('editor'));
//        dd(Setting::translatedIn('en')->get());
        $news = News::count();
        $tours = Tour::count();
        $orders = Order::count();
        $contacts = Contact::count();
        return view('admin.dashboard',['news' => $news,'tours' => $tours,'orders' => $orders,'contacts' => $contacts]);
    }

    public function sidebar()
    {
        if(!empty(getCookie('body_class'))){
            setcookie('body_class','',time() + (86400 * 30), "/");
        }else{
            setcookie('body_class','sidebar-shrink',time() + (86400 * 30), "/");
        }
    }
    public function base()
    {
        if(auth('admin')){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login');
        }
    }
}
