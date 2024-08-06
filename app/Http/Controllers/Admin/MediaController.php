<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:media-list|media-create|media-edit|media-delete|media-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:media-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:media-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:media-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:media-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        $media = Media::orderby('id','DESC')->paginate(admin_paginate());
        return view('admin.media.index',['media'=>$media]);
    }

    public function archive()
    {
        //
        $media = Media::onlyTrashed()->orderby('id','DESC')->paginate(admin_paginate());

        //$admins = Admin::onlyTrashed()->orderBy('id','DESC')->paginate(5);
        return view('admin.media.archive',['media'=>$media]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $media = Media::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('file_name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.media.search',['media'=>$media]);
        }else{
            return redirect()->route('admin.media.index')->with([
                'message' => trans('admin/common.messages.search_error'),
                'alert_type' => 'danger'
            ]);
        }
    }

    public function show($id)
    {
        $media = Media::find($id);
        $admin = Admin::where('id',$media->admin_id)->get()->first();
        return view('admin.media.show',['media'=>$media,'admin'=>$admin]);
    }
    public function edit($id)
    {
        $media = Media::find($id);
        $admin = Admin::where('id',$media->admin_id)->get()->first();
        return view('admin.media.edit',['media'=>$media,'admin'=>$admin]);
    }
    public function update($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'nullable',
            'file_name'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $media = Media::find($id);

        $media->name = $request->name;
        $media->file_name = str_replace('/storage/', '',$request->file_name);
//        dd($media);
        $media->save();

        return redirect()->route('admin.media.index')->with([
            'message' => trans('admin/media.messages.edited'),
            'alert_type' => 'success'
        ]);
    }


    public function destroy($id)
    {
        //
        $item = Media::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.media.archive')->with([
                'message' => trans('admin/media.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.media.index')->with([
                'message' => trans('admin/media.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function delete($id)
    {
        //
        $media = Media::find($id);
        Storage::disk('local')->delete($media->file_name);
        Media::find($id)->delete();

        return redirect()->route('admin.media.index')->with([
            'message' => trans('admin/media.messages.deleted'),
            'alert_type' => 'success'
        ]);
    }

    // mmm

    public function restore($id)
    {
        //
        Media::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.media.archive')->with([
            'message' => trans('admin/media.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.media.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Media::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.media.archive')->with([
            'message' => trans('admin/media.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.media.index')->with([
                'message' => trans('admin/media.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Media::destroy($ids);
        }else{
            Media::find($ids)->delete();
        }
        return redirect()->route('admin.media.index')->with([
            'message' => trans('admin/media.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
