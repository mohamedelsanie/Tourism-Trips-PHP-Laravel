<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    //
    public function contact()
    {
        return view('front.pages.contact');
    }
    public function about()
    {
        return view('front.pages.about');
    }
    public function order()
    {
        return view('front.pages.order');
    }
    public function page($slug)
    {
        $page = Page::where('slug',$slug)->first();
        if(!empty($page)){
        $comments = PageComment::orderBy('id','DESC')->where(['page_id' => $page->id,'parent' =>0,'status' => 'publish'])->with('children')->get();
        return view('front.pages.page',['page' => $page,'comments' => $comments]);
        }else{
            return abort(404);
        }
    }
    public function add_comment(Request $request)
    {
//        dd($request->all());
        if(!empty($request->page_id)){
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
            'page_id'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['comment'] = $request->comment;
        $data['page_id'] = $request->page_id;
        $data['status'] = getSetting('user_comment_status');
        $data['parent'] = $request->parent;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        PageComment::Create($data);
        return redirect()->back()->with([
            'message' => 'تم اضافة التعليق بنجاح إذا لم يظهر تلقائياً يعنى أنه بحتاج إذن الأدارة فلا تقلق!',
            'alert_type' => 'success'
        ]);
        }else{
            return abort(404);
        }
    }
}
