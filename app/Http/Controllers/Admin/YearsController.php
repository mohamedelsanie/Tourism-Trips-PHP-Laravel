<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Years;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:year-list|year-create|year-edit|year-delete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:year-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:year-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:year-delete,admin', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $years = Years::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.watch_years.index',['years'=>$years]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $years = Years::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.watch_years.index',['years'=>$years]);
        }else{
            return redirect()->route('admin.watch.years.index')->with([
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
        return view('admin.watch_years.create');
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
        $validator = Validator::make($request->all(), [
            'title'     => 'required|max:255|min:1',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['title'] = $request->title;
        Years::Create($data);

        return redirect()->route('admin.watch.years.index')->with([
            'message' => trans('admin/year.messages.created'),
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
        $year = Years::find($id);
        return view('admin.watch_years.edit',['year' => $year]);
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
            'title'     => 'required|max:255|min:1',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $year = Years::find($id);

        $year->title = $request->title;
        $year->save();

        return redirect()->route('admin.watch.years.index')->with([
            'message' => trans('admin/year.messages.edited',['year' => $year->title]),
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
        Years::find($id)->delete();

        return redirect()->route('admin.watch.years.index')->with([
            'message' => trans('admin/year.messages.deleted'),
            'alert_type' => 'success'
        ]);
    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.watch.years.index')->with([
                'message' => trans('admin/year.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Years::destroy($ids);
        }else{
            Years::find($ids)->delete();
        }
        return redirect()->route('admin.watch.years.index')->with([
            'message' => trans('admin/year.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
