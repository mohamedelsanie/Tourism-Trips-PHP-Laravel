<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Image;
use App\Models\Video;
use App\Models\News;
use App\Models\Order;
use App\Models\Page;
use App\Models\PageComment;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    //
    public function index()
    {
        $tours = Tour::where('status','publish')->orderBy('id','DESC')->limit(getSetting('tours_count'))->get();
        $news = News::where('status','publish')->orderBy('id','DESC')->limit(getSetting('news_count'))->get();
        $blog = News::where('status','publish')->orderBy('id','DESC')->limit(getSetting('footer_blog_count'))->get();
        $images = Image::where('status','publish')->orderBy('id','DESC')->limit(getSetting('images_count'))->get();
        $videos = Video::where('status','publish')->orderBy('id','DESC')->limit(10)->get();
        $testimonials = PageComment::where('page_id',getSetting('testimonials_page'))->orderBy('id','DESC')->limit(getSetting('testimonials_count'))->get();
        return view('front.homepage',['tours' => $tours,'news' => $news, 'blog' => $blog,'images' => $images,'testimonials' => $testimonials,'videos' => $videos]);
    }
    public function orders()
    {
        $orders = Order::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
//        dd($orders[0]->tour);
        return view('dashboard',['orders' => $orders]);
    }
    public function closed()
    {
        return view('closed');
    }

    public function send_message(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|max:255|min:3|required',
            'email'    => 'required',
            'subject'    => 'required',
            'message'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['from_name'] = $request->name;
        $data['from_email'] = $request->email;
        $data['subject'] = $request->subject;
        $data['massege'] = $request->message;

        Contact::Create($data);

        return redirect()->back()->with([
            'message' => 'تم إرسال الرسالة بنجاح',
            'alert_type' => 'success'
        ]);
    }
}
