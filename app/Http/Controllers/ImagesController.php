<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\ImageComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImagesController extends Controller
{
    //
    public function index()
    {
        $page_title = 'معرض الصور';
        $posts = Image::where(['status' => 'publish'])->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
        return view('front.images.index',['posts'=>$posts,'page_title' => $page_title]);
    }
    public function post($slug)
    {
        $post = Image::where(['slug' => $slug])->first();
        if(!empty($post)){
        $comments = ImageComment::orderBy('id','DESC')->where(['image_id' => $post->id,'parent' =>0,'status' => 'publish'])->with('children')->get();
        return view('front.images.show',['post'=>$post,'comments' => $comments]);
        }else{
            return abort(404);
        }
    }

    public function add_comment(Request $request)
    {
        if(!empty($request->image_id)){
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
            'image_id'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['comment'] = $request->comment;
        $data['image_id'] = $request->image_id;
        $data['status'] = getSetting('user_comment_status');
        $data['parent'] = $request->parent;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        ImageComment::Create($data);
        return redirect()->back()->with([
            'message' => 'تم اضافة التعليق بنجاح إذا لم يظهر تلقائياً يعنى أنه بحتاج إذن الأدارة فلا تقلق!',
            'alert_type' => 'success'
        ]);
        }else{
            return abort(404);
        }

    }
}
