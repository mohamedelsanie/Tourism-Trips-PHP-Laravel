<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:video-list|video-create|video-edit|video-delete|video-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:video-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:video-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:video-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:video-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }
    public function index()
    {
        //
        $ads = Video::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.videos.index',['ads'=>$ads]);
    }

    public function archive()
    {
        //
        $ads = Video::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.videos.archive',['ads'=>$ads]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $ads = Video::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.videos.index',['ads'=>$ads]);
        }else{
            return redirect()->route('admin.videos.index')->with([
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
        return view('admin.videos.create');
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
            'slug'    => 'required|unique:videos,slug',
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

        Video::Create($data);

        return redirect()->route('admin.videos.index')->with([
            'message' => trans('admin/video.messages.created'),
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
        $ad = Video::find($id);
        return view('admin.videos.show',['ad' => $ad]);
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
        $ad = Video::find($id);
        return view('admin.videos.edit',['ad' => $ad]);
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
            'slug'    => 'required|unique:videos,slug,'.$id.'id',
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

        $ad = Video::find($id);

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

        return redirect()->route('admin.videos.index')->with([
            'message' => trans('admin/video.messages.edited',['ad' => $ad->title]),
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
        $item = Video::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.videos.archive')->with([
                'message' => trans('admin/video.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.videos.index')->with([
                'message' => trans('admin/video.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Video::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.videos.archive')->with([
            'message' => trans('admin/video.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.videos.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Video::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.videos.archive')->with([
            'message' => trans('admin/video.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.videos.index')->with([
                'message' => trans('admin/video.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Video::destroy($ids);
        }else{
            Video::find($ids)->delete();
        }
        return redirect()->route('admin.videos.index')->with([
            'message' => trans('admin/video.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
