<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourComment;
use App\Models\TourOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Psr\Log\error;

class ToursController extends Controller
{
    //
    public function index()
    {
        $page_title = 'الرحلات السياحية';
        $posts = Tour::where(['status' => 'publish'])->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
        return view('front.tours.index',['posts'=>$posts,'page_title' => $page_title]);
    }

    public function search(Request $request)
    {
//        dd($request->all());
        $amount = explode('-', $request->amount);

        $page_title = 'Search';
        $from_date = $request->from_date;
        $from_place = $request->from_place;
        $to_date = $request->to_date;
        $to_place = $request->to_place;
        if(!empty($from_date) && !empty($to_place)){
            if(!empty($request->amount)){
                $min_price = $amount[0];
                $max_price = $amount[1];
                $posts = Tour::orderBy('id','DESC')
                    ->WhereTranslationLike('to_place', $to_place)
                    ->WhereTranslationLike('from_place', $from_place)
                    ->WhereBetween('price', [$min_price, $max_price])
                    ->orWhereBetween('from_date', [$from_date, $to_date])
                    ->orWhereBetween('to_date', [$from_date, $to_date])
                    ->paginate(getSetting('posts_per_page'));
            }else{
                $posts = Tour::orderBy('id','DESC')
                    ->WhereTranslationLike('to_place', $to_place)
                    ->WhereTranslationLike('from_place', $from_place)
                    ->orWhereBetween('from_date', [$from_date, $to_date])
                    ->orWhereBetween('to_date', [$from_date, $to_date])
                    ->paginate(getSetting('posts_per_page'));
            }
            return view('front.tours.index',['posts'=>$posts,'page_title' => $page_title]);
        }else{
            return redirect()->route('tours')->with([
                'message' => 'برجاء ضبط إعدادات البحث',
                'alert_type' => 'danger'
            ]);
        }
    }
    public function post($slug)
    {
        $post = Tour::where(['slug' => $slug])->first();
        if(!empty($post)){
            $comments = TourComment::orderBy('id','DESC')->where(['tour_id' => $post->id,'parent' =>0,'status' => 'publish'])->with('children')->get();
            $offers = TourOffer::orderBy('id','DESC')->where(['tour_id' => $post->id])->get();
            return view('front.tours.show',['post'=>$post,'comments' => $comments,'offers' => $offers]);
        }else{
            return abort(404);
        }
    }

    public function category($slug)
    {
        $category = TourCategory::where(['slug' => $slug])->first();
        if(!empty($category)){
            $posts = Tour::where(['category_id' => $category->id,'status' => 'publish'])->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
            return view('front.tours.category',['category'=>$category,'posts' => $posts]);
        }else{
            return abort(404);
        }
    }

    public function add_comment(Request $request)
    {
        if(!empty($request->tour_id)){
        if(empty($request->parent)){
            $request->merge(["parent" => 0]);
        }
        if(empty($request->user_id)){
            $request->merge(["user_id" => 1]);
        }
        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|max:255|min:3',
            'email'    => 'required',
            'comment'    => 'required',
            'tour_id'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['comment'] = $request->comment;
        $data['tour_id'] = $request->tour_id;
        $data['status'] = getSetting('user_comment_status');
        $data['parent'] = $request->parent;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        TourComment::Create($data);
        return redirect()->back()->with([
            'message' => 'تم اضافة التعليق بنجاح إذا لم يظهر تلقائياً يعنى أنه بحتاج إذن الأدارة فلا تقلق!',
            'alert_type' => 'success'
        ]);
        }else{
            return abort(404);
        }

    }
}