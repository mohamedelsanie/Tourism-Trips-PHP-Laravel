<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:offer-list|offer-create|offer-edit|offer-delete|offer-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:offer-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:offer-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:offer-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:offer-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $pages = Offer::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.offers.index',['pages'=>$pages]);
    }

    public function archive()
    {
        //
        $pages = Offer::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.offers.archive',['pages'=>$pages]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $pages = Offer::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.offers.index',['pages'=>$pages]);
        }else{
            return redirect()->route('admin.offers.index')->with([
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
        return view('admin.offers.create');
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
            'slug'    => 'required|unique:offers,slug',
            'image'    => 'nullable',
            'price'    => 'required',
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
        $data['price'] = $request->price;
        $data['admin_id'] = $request->admin_id;
//        dd($data);

        Offer::Create($data);

        return redirect()->route('admin.offers.index')->with([
            'message' => trans('admin/offer.messages.created'),
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
        $page = Offer::find($id);
        return view('admin.offers.show',['page' => $page]);
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
        $page = Offer::find($id);
        return view('admin.offers.edit',['page' => $page]);
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
            'slug'    => 'required|unique:tours,slug,'.$id.'id',
            'image'    => 'nullable',
            'price'    => 'required',
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
//        dd($request->all());
        $page = Offer::find($id);

        foreach (config('translatable.languages') as $key => $value) {
            $page->translate($key)->title = $request->$key['title'];
            $page->translate($key)->content = $request->$key['content'];
            $page->translate($key)->description = $request->$key['description'];
        }
        $page->slug = $request->slug;
        $page->image = $request->image;
        $page->price = $request->price;
        $page->admin_id = $page->admin_id;
//        dd($data);

        $page->save();

        return redirect()->route('admin.offers.index')->with([
            'message' => trans('admin/offer.messages.edited',['page' => $page->title]),
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
        $item = Offer::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.offers.archive')->with([
                'message' => trans('admin/offer.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.offers.index')->with([
                'message' => trans('admin/offer.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Offer::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.offers.archive')->with([
            'message' => trans('admin/offer.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.offers.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Offer::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.offers.archive')->with([
            'message' => trans('admin/offer.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.offers.index')->with([
                'message' => trans('admin/offer.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Offer::destroy($ids);
        }else{
            Offer::find($ids)->delete();
        }
        return redirect()->route('admin.offers.index')->with([
            'message' => trans('admin/offer.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
