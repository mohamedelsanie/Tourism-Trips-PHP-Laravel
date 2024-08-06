<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\ImageComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImagesCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:imagecomment-list|imagecomment-create|imagecomment-edit|imagecomment-delete|imagecomment-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:imagecomment-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:imagecomment-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:imagecomment-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:imagecomment-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $comments = ImageComment::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.image_comments.index',['comments'=>$comments]);
    }

    public function archive()
    {
        //
        $comments = ImageComment::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.image_comments.archive',['comments'=>$comments]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $comments = ImageComment::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.image_comments.index',['comments'=>$comments]);
        }else{
            return redirect()->route('admin.image.comments.index')->with([
                'message' => trans('admin/common.messages.search_error'),
                'alert_type' => 'danger'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $posts = Image::all();
        $users = User::all();
        return view('admin.image_comments.create',['posts'=>$posts,'users'=>$users]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->all());
        $request->merge(["parent" => 0]);
        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|max:255|min:3',
            'comment'    => 'required',
            'image_id'    => 'required',
            'user_id'    => 'required',
            'status'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data['name'] = $request->name;
        $data['comment'] = $request->comment;
        $data['status'] = $request->status;
        $data['image_id'] = $request->image_id;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        ImageComment::Create($data);
        return redirect()->route('admin.image.comments.index')->with([
            'message' => trans('admin/image_comment.messages.created'),
            'alert_type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $comment = ImageComment::find($id);
        $comment_user = User::find($comment ->user_id);
        $comment_post = Image::find($comment ->post_id);
        return view('admin.image_comments.show',['comment' => $comment,'comment_user'=>$comment_user,'comment_post'=>$comment_post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $comment = ImageComment::find($id);
        $posts = Image::all();
        $users = User::all();
        return view('admin.image_comments.edit',['comment'=>$comment,'posts'=>$posts,'users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'     => 'nullable|max:255|min:3',
            'comment'    => 'required',
            'image_id'    => 'required',
            'user_id'    => 'required',
            'status'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = ImageComment::find($id);

        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->status = $request->status;
        $comment->image_id = $request->image_id;
        $comment->user_id = $request->user_id;
        $comment->comment_stars = $request->comment_stars;
        $comment->save();
        return redirect()->route('admin.image.comments.index')->with([
            'message' => trans('admin/image_comment.messages.edited',['comment' => $comment->name]),
            'alert_type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //
        $item = ImageComment::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.image.comments.archive')->with([
                'message' => trans('admin/image_comment.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.image.comments.index')->with([
                'message' => trans('admin/image_comment.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        ImageComment::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.image.comments.archive')->with([
            'message' => trans('admin/image_comment.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.image.comments.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                ImageComment::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //Image::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.image.comments.archive')->with([
            'message' => trans('admin/image_comment.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.image.comments.index')->with([
                'message' => trans('admin/image_comment.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            ImageComment::destroy($ids);
        }else{
            ImageComment::find($ids)->delete();
        }
        return redirect()->route('admin.image.comments.index')->with([
            'message' => trans('admin/image_comment.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}

