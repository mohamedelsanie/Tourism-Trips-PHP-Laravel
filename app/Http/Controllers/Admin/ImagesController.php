<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:image-list|image-create|image-edit|image-delete|image-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:image-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:image-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:image-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:image-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }
    public function index()
    {
        //
        $ads = Image::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.images.index',['ads'=>$ads]);
    }

    public function archive()
    {
        //
        $ads = Image::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.images.archive',['ads'=>$ads]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $ads = Image::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.images.index',['ads'=>$ads]);
        }else{
            return redirect()->route('admin.images.index')->with([
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
        return view('admin.images.create');
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
            'slug'    => 'required|unique:images,slug',
            'image'    => 'nullable',
            'status'    => 'required',
            'gallery'    => 'nullable',
            'comments_status'    => 'nullable',
            'admin_id'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.content'] =  'nullable';
            $valid_data[$key.'*.description'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        foreach (config('translatable.languages') as $key => $value) {
            $data[$key]['title'] = $request->$key['title'];
            $data[$key]['content'] = $request->$key['content'];
            $data[$key]['description'] = $request->$key['description'];
        }

        $data['slug'] = $request->slug;
        $data['image'] = $request->image;
        $data['status'] = $request->status;
        $data['gallery'] = $request->gallery;
        $data['comments_status'] = $request->comments_status;
        $data['admin_id'] = $request->admin_id;
        Image::Create($data);

        return redirect()->route('admin.images.index')->with([
            'message' => trans('admin/image.messages.created'),
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
        $ad = Image::find($id);
        return view('admin.images.show',['ad' => $ad]);
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
        $ad = Image::find($id);
        return view('admin.images.edit',['ad' => $ad]);
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
        $request->merge(["admin_id" => auth()->guard('admin')->user()->id]);
        $valid_data = [
            'slug'    => 'required|unique:images,slug,'.$id.'id',
            'image'    => 'nullable',
            'status'    => 'required',
            'gallery'    => 'nullable',
            'comments_status'    => 'nullable',
            'admin_id'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.content'] =  'nullable';
            $valid_data[$key.'*.description'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ad = Image::find($id);

        foreach (config('translatable.languages') as $key => $value) {
            $ad->translate($key)->title = $request->$key['title'];
            $ad->translate($key)->content = $request->$key['content'];
            $ad->translate($key)->description = $request->$key['description'];
        }


        $ad->slug = $request->slug;
        $ad->image = $request->image;
        $ad->status = $request->status;
        $ad->comments_status = $request->comments_status;
        $ad->gallery = $request->gallery;
        $ad->admin_id = $request->admin_id;

        $ad->save();

        return redirect()->route('admin.images.index')->with([
            'message' => trans('admin/image.messages.edited',['ad' => $ad->title]),
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
        $item = Image::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.images.archive')->with([
                'message' => trans('admin/image.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.images.index')->with([
                'message' => trans('admin/image.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Image::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.images.archive')->with([
            'message' => trans('admin/image.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.images.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Image::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.images.archive')->with([
            'message' => trans('admin/image.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.images.index')->with([
                'message' => trans('admin/image.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Image::destroy($ids);
        }else{
            Image::find($ids)->delete();
        }
        return redirect()->route('admin.images.index')->with([
            'message' => trans('admin/image.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
