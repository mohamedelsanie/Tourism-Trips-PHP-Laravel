<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:page-list|page-create|page-edit|page-delete|page-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:page-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:page-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:page-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:page-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $pages = Page::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.pages.index',['pages'=>$pages]);
    }

    public function archive()
    {
        //
        $pages = Page::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.pages.archive',['pages'=>$pages]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $pages = Page::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.pages.index',['pages'=>$pages]);
        }else{
            return redirect()->route('admin.pages.index')->with([
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
        return view('admin.pages.create');
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
//        dd($request->all());

        $valid_data = [
            'slug'    => 'required|unique:pages,slug',
            'image'    => 'nullable',
            'status'    => 'required',
            'template'    => 'nullable',
            'comments_status'    => 'nullable',
            'admin_id'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.content'] =  'nullable';
            $valid_data[$key.'*.meta_description'] =  'nullable';
            $valid_data[$key.'*.meta_tags'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //dd($request->en['title']);
        foreach (config('translatable.languages') as $key => $value) {
            $data[$key]['title'] = $request->$key['title'];
            $data[$key]['content'] = $request->$key['content'];
            $data[$key]['meta_description'] = $request->$key['meta_description'];
            $data[$key]['meta_tags'] = $request->$key['meta_tags'];
        }


        $data['slug'] = $request->slug;
        $data['image'] = $request->image;
        $data['status'] = $request->status;
        $data['comments_status'] = $request->comments_status;
        $data['admin_id'] = $request->admin_id;
//        dd($data);

        Page::Create($data);

        return redirect()->route('admin.pages.index')->with([
            'message' => trans('admin/page.messages.created'),
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
        $page = Page::find($id);
        return view('admin.pages.show',['page' => $page]);
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
        $page = Page::find($id);
        return view('admin.pages.edit',['page' => $page]);
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
            'slug'    => 'required|unique:pages,slug,'.$id.'id',
            'image'    => 'nullable',
            'status'    => 'required',
            'comments_status'    => 'nullable',
            'admin_id'    => 'nullable',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.content'] =  'nullable';
            $valid_data[$key.'*.meta_description'] =  'nullable';
            $valid_data[$key.'*.meta_tags'] =  'nullable';
        }


        $validator = Validator::make($request->all(), $valid_data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $page = Page::find($id);
        foreach (config('translatable.languages') as $key => $value) {
            $page->translate($key)->title = $request->$key['title'];
            $page->translate($key)->content = $request->$key['content'];
            $page->translate($key)->meta_description = $request->$key['meta_description'];
            $page->translate($key)->meta_tags = $request->$key['meta_tags'];
        }
        $page->slug = $request->slug;
        $page->image = $request->image;
        $page->status = $request->status;
        $page->comments_status = $request->comments_status;
        $page->admin_id = $page->admin_id;
//        dd($data);

        $page->save();

        return redirect()->route('admin.pages.index')->with([
            'message' => trans('admin/page.messages.edited',['page' => $page->title]),
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
        $item = Page::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.pages.archive')->with([
                'message' => trans('admin/page.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.pages.index')->with([
                'message' => trans('admin/page.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Page::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.pages.archive')->with([
            'message' => trans('admin/page.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.pages.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Page::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.pages.archive')->with([
            'message' => trans('admin/page.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.pages.index')->with([
                'message' => trans('admin/page.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Page::destroy($ids);
        }else{
            Page::find($ids)->delete();
        }
        return redirect()->route('admin.pages.index')->with([
            'message' => trans('admin/page.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
