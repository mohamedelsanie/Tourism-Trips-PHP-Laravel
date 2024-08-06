<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\VideoComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideosController extends Controller
{
    //
    public function index()
    {
        $page_title = 'معرض الفيديو';
        $posts = Video::where(['status' => 'publish'])->orderBy('id','DESC')->paginate(getSetting('posts_per_page'));
        return view('front.videos.index',['posts'=>$posts,'page_title' => $page_title]);
    }
    public function post($slug)
    {
        $post = Video::where(['slug' => $slug])->first();
        if(!empty($post)){
        $comments = VideoComment::orderBy('id','DESC')->where(['video_id' => $post->id,'parent' =>0,'status' => 'publish'])->with('children')->get();
        return view('front.videos.show',['post'=>$post,'comments' => $comments]);
        }else{
            return abort(404);
        }
    }

    public function add_comment(Request $request)
    {
        if(!empty($request->video_id)){
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
            'video_id'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['comment'] = $request->comment;
        $data['video_id'] = $request->video_id;
        $data['status'] = getSetting('user_comment_status');
        $data['parent'] = $request->parent;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        VideoComment::Create($data);
        return redirect()->back()->with([
            'message' => 'تم اضافة التعليق بنجاح إذا لم يظهر تلقائياً يعنى أنه بحتاج إذن الأدارة فلا تقلق!',
            'alert_type' => 'success'
        ]);
        }else{
            return abort(404);
        }

    }
}
