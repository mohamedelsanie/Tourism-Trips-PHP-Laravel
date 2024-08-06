<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use App\Models\UsersRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use DB;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:admin-list|admin-create|admin-edit|admin-delete|admin-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:admin-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:admin-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:admin-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:admin-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }
    public function index()
    {
        //
//        $admins = admin::orderBy('id','DESC')->paginate(5);

        $admins = Admin::orderBy('id','DESC')->paginate(admin_paginate());

//        dd($admins);
        return view('admin.admins.index',['admins'=>$admins]);
    }

    public function archive()
    {
        //
        $admins = Admin::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());

        //$admins = Admin::onlyTrashed()->orderBy('id','DESC')->paginate(5);
        return view('admin.admins.archive',['admins'=>$admins]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $admins = Admin::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.admins.index',['admins'=>$admins]);
        }else{
            return redirect()->route('admin.admins.index')->with([
                'message' => 'Search Field Is Empty',
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
        $roles = Role::pluck('name','name')->all();
        return view('admin.admins.create',['roles'=>$roles]);
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
            'name'     => 'required|max:255|min:3|required',
            'email'    => 'required',
            'password'    => 'required',
            'image'    => 'nullable',
            'dob'    => 'nullable',
            'status'    => 'required',
            'roles' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['image'] = $request->image;
        $data['dob'] = $request->dob;
        $data['status'] = $request->status;

//        dd($request->all());

        $admin = Admin::Create($data);

        $admin->assignRole($request->roles);

        return redirect()->route('admin.admins.index')->with([
            'message' => trans('admin/admin.messages.created'),
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
        $admin = Admin::find($id);
        return view('admin.admins.show',['admin'=>$admin]);
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
        $admin = Admin::find($id);
        $roles = Role::pluck('name','name')->all();
        $adminRole = $admin->roles->pluck('name','name')->all();
//        dd(array_keys($adminRole),$roles);

        return view('admin.admins.edit',['admin'=>$admin,'admin_role'=>$adminRole,'roles'=>$roles]);
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
            'name'     => 'required|max:255|min:3|required',
            'email'    => 'required',
            'edit_password'    => 'nullable',
            'image'    => 'nullable',
            'dob'    => 'nullable',
            'status'    => 'required',
            'roles'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $admin = Admin::find($id);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->image = $request->image;
        $admin->dob = $request->dob;
        $admin->status = $request->status;


        if($request->edit_password){
            $admin->password = bcrypt($request->edit_password);
        }

        if(!empty(request('roles'))){
            DB::table('model_has_roles')->where('model_id',$id)->delete();

            $admin->assignRole($request->roles);
        }
        $admin->save();

        return redirect()->route('admin.admins.index')->with([
            'message' => trans('admin/admin.messages.edited',['admin' => $admin->name]),
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
        $item = Admin::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.admins.archive')->with([
                'message' => trans('admin/admin.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.admins.index')->with([
                'message' => trans('admin/admin.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Admin::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.admins.archive')->with([
            'message' => trans('admin/admin.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.admins.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Admin::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.admins.archive')->with([
            'message' => trans('admin/admin.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.admins.index')->with([
                'message' => trans('admin/admin.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Admin::destroy($ids);
        }else{
            Admin::find($ids)->delete();
        }
        return redirect()->route('admin.admins.index')->with([
            'message' => trans('admin/admin.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }

}
