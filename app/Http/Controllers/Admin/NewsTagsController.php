<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:posttag-list|posttag-create|posttag-edit|posttag-delete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:posttag-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:posttag-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:posttag-delete,admin', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $tags = NewsTag::orderBy('id','DESC')->paginate(admin_paginate());

        return view('admin.tags.index',['tags'=>$tags]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $tags = NewsTag::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.tags.index',['tags'=>$tags]);
        }else{
            return redirect()->route('admin.tags.index')->with([
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
        return view('admin.tags.create');
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
        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach (config('translatable.languages') as $key => $value) {
            $data[$key]['title'] = $request->$key['title'];
        }

        NewsTag::Create($data);
        return redirect()->route('admin.tags.index')->with([
            'message' => trans('admin/tag.messages.created'),
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
        $tag = NewsTag::find($id);
        return view('admin.tags.show',['tag'=>$tag]);
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
        $tag = NewsTag::find($id);
        return view('admin.tags.edit',['tag'=>$tag]);
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
        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
        }
        $validator = Validator::make($request->all(), $valid_data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tag = NewsTag::find($id);
        foreach (config('translatable.languages') as $key => $value) {
            $tag->translate($key)->title = $request->$key['title'];
        }
        $tag->save();
        return redirect()->route('admin.tags.index')->with([
            'message' => trans('admin/tag.messages.edited',['tag' => $tag->title]),
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
        NewsTag::find($id)->delete();

        return redirect()->route('admin.tags.index')->with([
            'message' => trans('admin/tag.messages.deleted'),
            'alert_type' => 'success'
        ]);
    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.tags.index')->with([
                'message' => trans('admin/tag.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            NewsTag::destroy($ids);
        }else{
            NewsTag::find($ids)->delete();
        }
        return redirect()->route('admin.tags.index')->with([
            'message' => trans('admin/tag.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
