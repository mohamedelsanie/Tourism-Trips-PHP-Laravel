<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsComment;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    //
    public function index()
    {
        $page_title = 'الاخبار';
        $posts = News::where(['status' => 'publish'])->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
        return view('front.news.index',['posts'=>$posts,'page_title' => $page_title]);
    }
    public function post($slug)
    {
        $post = News::where(['slug' => $slug])->first();
        if(!empty($post)){
        $comments = NewsComment::orderBy('id','DESC')->where(['post_id' => $post->id,'parent' =>0,'status' => 'publish'])->with('children')->get();
        $tags = Tags::orderBy('id','DESC')->where(['post_id' => $post->id,'type' => 'news'])->get();
        return view('front.news.show',['post'=>$post,'comments' => $comments,'tags' => $tags]);
        }else{
            return abort(404);
        }
    }

    public function category($slug)
    {
        $category = NewsCategory::where(['slug' => $slug])->first();
        if(!empty($category)){
        $posts = News::where(['category_id' => $category->id,'status' => 'publish'])->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
        return view('front.news.category',['category'=>$category,'posts' => $posts]);
        }else{
            return abort(404);
        }
    }

    public function add_comment(Request $request)
    {
        if(!empty($request->post_id)){
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
            'post_id'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['comment'] = $request->comment;
        $data['post_id'] = $request->post_id;
        $data['status'] = getSetting('user_comment_status');
        $data['parent'] = $request->parent;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        NewsComment::Create($data);
        return redirect()->back()->with([
            'message' => 'تم اضافة التعليق بنجاح إذا لم يظهر تلقائياً يعنى أنه بحتاج إذن الأدارة فلا تقلق!',
            'alert_type' => 'success'
        ]);
        }else{
            return abort(404);
        }

    }
}
