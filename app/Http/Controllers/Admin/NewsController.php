<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:news-list|news-create|news-edit|news-delete|news-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:news-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:news-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:news-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:news-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $posts = News::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.posts.index',['posts'=>$posts]);
    }

    public function archive()
    {
        //
        $posts = News::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.posts.archive',['posts'=>$posts]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $posts = News::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.posts.index',['posts'=>$posts]);
        }else{
            return redirect()->route('admin.posts.index')->with([
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
        $categories = NewsCategory::all();
        $tags = NewsTag::all();

        if(count($categories)>0){
            return view('admin.posts.create',['categories'=>$categories,'tags'=>$tags]);
        }else{
            return redirect()->route('admin.posts.index')->with([
                'message' => trans('admin/news.messages.no_categories'),
                'alert_type' => 'danger'
            ]);
        }
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
        $request->merge(["admin_id" => auth()->guard('admin')->user()->id]);
        $valid_data = [
            'slug'    => 'required|unique:news,slug',
            'image'    => 'nullable',
            'category_id'    => 'nullable',
            'comments_status'    => 'nullable',
            'status'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title']   = 'required|max:255|min:3|required';
            $valid_data[$key.'*.description'] =  'nullable';
            $valid_data[$key.'*.content'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach (config('translatable.languages') as $key => $value) {
            $data[$key]['title'] = $request->$key['title'];
            $data[$key]['description'] = $request->$key['description'];
            $data[$key]['content'] = $request->$key['content'];
        }
        $data['slug'] = $request->slug;
        $data['image'] = $request->image;
        $data['category_id'] = $request->category_id;
        $data['comments_status'] = $request->comments_status;
        $data['status'] = $request->status;
        $data['admin_id'] = $request->admin_id;
        $post = News::Create($data);
        $pid = $post->id;
        if($request->tags){
            foreach ($request->tags as $tag) {
                Tags::Create(['post_id'=>$pid,'tag_id'=>$tag,'type'=>'news']);
            }
        }
        return redirect()->route('admin.posts.index')->with([
            'message' => trans('admin/news.messages.created'),
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
        $post = News::find($id);
        $post_cat = NewsCategory::find($post->category);
        $post_comments = NewsComment::orderBy('id','DESC')->where('post_id',$id)->paginate(5);
//        dd($post_comments);
        return view('admin.posts.show',['post' => $post,'post_category'=>$post_cat,'post_comments'=>$post_comments]);
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
        $categories = NewsCategory::all();
        $post = News::find($id);
        $tags = NewsTag::all();
        $post_tags = Tags::where(['post_id' => $id,'type' => 'news'])->get();
        $p_tags = $post_tags->pluck('tag_id')->toArray();
//        dd($post_tags);
        return view('admin.posts.edit',['post'=>$post,'categories'=>$categories,'tags'=>$tags,'post_tags'=>$post_tags,'p_tags' => $p_tags]);
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
        $valid_data = [
            'slug'    => 'required|unique:news,slug,'.$id.'id',
            'image'    => 'nullable',
            'category_id'    => 'nullable',
            'comments_status'    => 'nullable',
            'status'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.description'] =  'nullable';
            $valid_data[$key.'*.content'] =  'nullable';
        }
        $validator = Validator::make($request->all(), $valid_data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = News::find($id);

        foreach (config('translatable.languages') as $key => $value) {
            $post->translate($key)->title = $request->$key['title'];
            $post->translate($key)->description = $request->$key['description'];
            $post->translate($key)->content = $request->$key['content'];
        }

        $post->slug = $request->slug;
        $post->image = $request->image;
        $post->category_id = $request->category_id;
        $post->comments_status = $request->comments_status;
        $post->status = $request->status;

        $post_tags = Tags::where(['post_id' => $id,'type' => 'news'])->get();
        $tags = NewsTag::all();
        if(!empty(request('tags'))){
            foreach($tags as $tag){
                if(in_array($tag->id,request('tags'))){
                    $foc = Tags::updateOrCreate([
                        'post_id' => $id,
                        'tag_id' => $tag->id,
                        'type' => 'news',
                    ]);
                    $foc->save();
                }else{
                    $tag_post = Tags::where([
                        'post_id' => $id,
                        'type' => 'news',
                    ])->get();
                    if(!empty($tag_post)){
                        foreach($tag_post as $tagp){
                            if(in_array($tagp->tag_id,request('tags'))){
                                $the_data = [
                                    'post_id' => $id,
                                    'tag_id' => $tagp->tag_id,
                                    'type' => 'news',
                                ];
                                Tags::where([
                                    'post_id' => $id,
                                    'tag_id' => $tagp->tag_id,
                                    'type' => 'news',
                                ])->update($the_data);
                            }else{
                                Tags::where([
                                    'post_id' => $id,
                                    'tag_id' => $tagp->tag_id,
                                    'type' => 'news',
                                ])->delete();

                            }
                        }
                    }

                }
            }
        }else{
            Tags::where(['post_id' => $id,'type' => 'news'])->delete();
        }
        $post->save();

        return redirect()->route('admin.posts.index')->with([
            'message' => trans('admin/news.messages.edited',['post' => $post->title]),
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
        $item = News::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.posts.archive')->with([
                'message' => trans('admin/news.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.posts.index')->with([
                'message' => trans('admin/news.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.posts.index')->with([
                'message' => trans('admin/news.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            foreach ($ids as $id) {
                $item = News::withTrashed()->find($id);
                if($item->trashed()){
                    $item->forceDelete();
                }else{
                    $item->delete();
                }
            }
        }
        return redirect()->route('admin.posts.index')->with([
            'message' => trans('admin/news.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function restore($id)
    {
        //
        News::onlyTrashed()->find($id)->restore();
        return redirect()->route('admin.posts.archive')->with([
            'message' => trans('admin/news.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.posts.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                News::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.posts.archive')->with([
            'message' => trans('admin/news.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
}

