<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:permission-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete,admin', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $permissions = Permission::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.permissions.index',['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $permissions = Permission::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.permissions.index',['permissions'=>$permissions]);
        }else{
            return redirect()->route('admin.permissions.index')->with([
                'message' => trans('admin/common.messages.search_error'),
                'alert_type' => 'danger'
            ]);
        }
    }
    public function create()
    {
        //
        return view('admin.permissions.create');
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
            'name' => 'required|unique:permissions,name',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Permission::create(['title' => $request->title,'name' => $request->name,'guard_name' => 'admin']);

        return redirect()->route('admin.permissions.index')->with([
            'message' => trans('admin/permission.messages.created'),
            'alert_type' => 'success'
        ]);
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
        $permission = Permission::find($id);
        return view('admin.permissions.edit',['permission'=>$permission]);
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
            'name'    => 'required|unique:permissions,name,'.$id.'id',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $permission = Permission::find($id);
        $permission->title = $request->title;
        $permission->name = $request->name;
        $permission->guard_name = 'admin';
        $permission->save();


        return redirect()->route('admin.permissions.index')->with([
            'message' => trans('admin/permission.messages.edited',['permission' => $permission->title]),
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
        Permission::find($id)->delete();

        return redirect()->route('admin.permissions.index')->with([
            'message' => trans('admin/permission.messages.deleted'),
            'alert_type' => 'success'
        ]);
    }

    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.permissions.index')->with([
                'message' => trans('admin/permission.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Permission::destroy($ids);
        }else{
            Permission::find($ids)->delete();
        }
        return redirect()->route('admin.permissions.index')->with([
            'message' => trans('admin/permission.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
