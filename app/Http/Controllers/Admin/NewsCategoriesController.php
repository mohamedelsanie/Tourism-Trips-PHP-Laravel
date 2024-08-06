<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:postcategory-list|postcategory-create|postcategory-edit|postcategory-delete|postcategory-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:postcategory-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:postcategory-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:postcategory-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:postcategory-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $categories = NewsCategory::orderBy('id','DESC')->paginate(admin_paginate());
        $cats = NewsCategory::tree($categories);
        return view('admin.post_categories.index',['categories'=>$categories,'cats'=>$cats]);
    }

    public function archive()
    {
        //
        $categories = NewsCategory::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.post_categories.archive',['categories'=>$categories]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $categories = NewsCategory::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.post_categories.index',['categories'=>$categories]);
        }else{
            return redirect()->route('admin.categories.index')->with([
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
        return view('admin.post_categories.create',['categories'=>$categories]);
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
        $valid_data = [
            'slug'    => 'required|unique:news_categories,slug',
            'parent'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.description'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach (config('translatable.languages') as $key => $value) {
            $data[$key]['title'] = $request->$key['title'];
            $data[$key]['description'] = $request->$key['description'];
        }

        $data['slug'] = $request->slug;
        $data['parent'] = $request->parent;
//        dd($data);

        NewsCategory::Create($data);

        return redirect()->route('admin.categories.index')->with([
            'message' => trans('admin/category.messages.created'),
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
        $category = NewsCategory::find($id);
        return view('admin.post_categories.show',['category' => $category]);
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
        $category = NewsCategory::find($id);
        return view('admin.post_categories.edit',['category' => $category,'categories'=>$categories]);
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
            'slug'    => 'required|unique:news_categories,slug,'.$id.'id',
            'parent'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.description'] =  'nullable';
        }
        $validator = Validator::make($request->all(), $valid_data);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $category = NewsCategory::find($id);
        foreach (config('translatable.languages') as $key => $value) {
            $category->translate($key)->title = $request->$key['title'];
            $category->translate($key)->description = $request->$key['description'];
        }
        $category->slug = $request->slug;
        $category->parent = $request->parent;
        $category->save();

        return redirect()->route('admin.categories.index')->with([
            'message' => trans('admin/category.messages.edited',['category' => $category->title]),
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
        $cats = NewsCategory::all();
        $item = NewsCategory::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            foreach ($cats as $cat){
                NewsCategory::where('parent',$cat->id)->forceDelete();
            }
            return redirect()->route('admin.categories.archive')->with([
                'message' => trans('admin/category.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            foreach ($cats as $cat){
                NewsCategory::where('parent',$cat->id)->delete();
            }
            return redirect()->route('admin.categories.index')->with([
                'message' => trans('admin/category.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        NewsCategory::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.categories.archive')->with([
            'message' => trans('admin/category.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.categories.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                NewsCategory::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.categories.archive')->with([
            'message' => trans('admin/category.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.categories.index')->with([
                'message' => trans('admin/category.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            NewsCategory::destroy($ids);
        }else{
            NewsCategory::find($ids)->delete();
        }
        return redirect()->route('admin.categories.index')->with([
            'message' => trans('admin/category.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
