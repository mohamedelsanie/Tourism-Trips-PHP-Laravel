<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:role-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete,admin', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.roles.index',['roles' => $roles]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $roles = Role::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.roles.index',['roles'=>$roles]);
        }else{
            return redirect()->route('admin.roles.index')->with([
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
        $permissions = Permission::get();
        return view('admin.roles.create',['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::create(['guard_name' => 'admin','name' => $request->name]);
//        dd($role->syncPermissions($request->permission));
        $role->syncPermissions($request->permission);

        return redirect()->route('admin.roles.index')->with([
            'message' => trans('admin/role.messages.created'),
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
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('admin.roles.show',['role' => $role,'rolePermissions' => $rolePermissions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        return view('admin.roles.edit',['role' => $role,'permissions' => $permissions,'rolePermissions' => $rolePermissions]);
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


        $validator = Validator::make($request->all(), [
            'name'    => 'required|unique:roles,name,'.$id.'id',
            'permission' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = 'admin';
        $role->save();

        $role->syncPermissions($request->permission);

        return redirect()->route('admin.roles.index')->with([
            'message' => trans('admin/role.messages.edited',['role' => $role->name]),
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
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('admin.roles.index')->with([
            'message' => trans('admin/role.messages.deleted'),
            'alert_type' => 'success'
        ]);
    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.roles.index')->with([
                'message' => trans('admin/role.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Role::destroy($ids);
        }else{
            Role::find($ids)->delete();
        }
        return redirect()->route('admin.roles.index')->with([
            'message' => trans('admin/role.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}