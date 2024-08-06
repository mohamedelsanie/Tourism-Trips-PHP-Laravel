<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:pagecomment-list|pagecomment-create|pagecomment-edit|pagecomment-delete|pagecomment-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:pagecomment-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:pagecomment-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:pagecomment-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:pagecomment-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $comments = PageComment::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.page_comments.index',['comments'=>$comments]);
    }

    public function archive()
    {
        //
        $comments = PageComment::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.page_comments.archive',['comments'=>$comments]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $comments = PageComment::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.page_comments.index',['comments'=>$comments]);
        }else{
            return redirect()->route('admin.page.comments.index')->with([
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
        $posts = Page::all();
        $users = User::all();
        return view('admin.page_comments.create',['posts'=>$posts,'users'=>$users]);
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
            'page_id'    => 'required',
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
        $data['page_id'] = $request->page_id;
        $data['user_id'] = $request->user_id;
        $data['comment_stars'] = $request->comment_stars;
        PageComment::Create($data);
        return redirect()->route('admin.page.comments.index')->with([
            'message' => trans('admin/page_comment.messages.created'),
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
        $comment = PageComment::find($id);
        $comment_user = User::find($comment ->user_id);
        $comment_post = Page::find($comment ->post_id);
        return view('admin.page_comments.show',['comment' => $comment,'comment_user'=>$comment_user,'comment_post'=>$comment_post]);
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
        $comment = PageComment::find($id);
        $posts = Page::all();
        $users = User::all();
        return view('admin.page_comments.edit',['comment'=>$comment,'posts'=>$posts,'users'=>$users]);
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
            'page_id'    => 'required',
            'user_id'    => 'required',
            'status'    => 'required',
            'comment_stars'    => 'nullable',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = PageComment::find($id);

        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->status = $request->status;
        $comment->page_id = $request->page_id;
        $comment->user_id = $request->user_id;
        $comment->comment_stars = $request->comment_stars;
        $comment->save();
        return redirect()->route('admin.page.comments.index')->with([
            'message' => trans('admin/page_comment.messages.edited',['comment' => $comment->name]),
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
        $item = PageComment::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.page.comments.archive')->with([
                'message' => trans('admin/page_comment.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.page.comments.index')->with([
                'message' => trans('admin/page_comment.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        PageComment::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.page.comments.archive')->with([
            'message' => trans('admin/page_comment.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.page.comments.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                PageComment::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //Page::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.page.comments.archive')->with([
            'message' => trans('admin/page_comment.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.page.comments.index')->with([
                'message' => trans('admin/page_comment.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            PageComment::destroy($ids);
        }else{
            PageComment::find($ids)->delete();
        }
        return redirect()->route('admin.page.comments.index')->with([
            'message' => trans('admin/page_comment.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}

