<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete|user-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:user-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:user-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $users = User::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.users.index',['users'=>$users]);
    }



    public function archive()
    {
        //
        $users = User::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.users.archive',['users'=>$users]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $users = User::orderBy('id','DESC')
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.users.index',['users'=>$users]);
        }else{
            return redirect()->route('admin.users.index')->with([
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
        return view('admin.users.create');
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
            'email'    => 'required|unique:users,email',
            'password'    => 'required',
            'image'    => 'nullable',
            'dob'    => 'nullable',
            'phone_code'    => 'nullable',
            'phone'    => 'nullable|unique:users,phone',
            'quaote'    => 'nullable',
            'status'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['image'] = $request->image;
        $data['dob'] = $request->dob;
        $data['phone_code'] = $request->phone_code;
        $data['phone'] = $request->phone;
        $data['quaote'] = $request->quaote;
        $data['status'] = $request->status;
//        dd($request->all());

        User::Create($data);

        return redirect()->route('admin.users.index')->with([
            'message' => trans('admin/user.messages.created'),
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
        $user = User::find($id);
        return view('admin.users.show',['user'=>$user]);
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
        $user = User::find($id);
        return view('admin.users.edit',['user'=>$user]);
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
            'email'    => 'required|unique:users,email,'.$id.'id',
            'edit_password'    => 'nullable',
            'image'    => 'nullable',
            'dob'    => 'nullable',
            'phone_code'    => 'nullable',
            'phone'    => 'nullable|unique:users,phone,'.$id.'id',
            'quaote'    => 'nullable',
            'status'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $request->image;
        $user->dob = $request->dob;
        $user->phone_code = $request->phone_code;
        $user->phone = $request->phone;
        $user->quaote = $request->quaote;
        $user->status = $request->status;


        if($request->edit_password){
            $user->password = bcrypt($request->edit_password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with([
            'message' => trans('admin/user.messages.edited',['user' => $user->name]),
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
        $item = User::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.users.archive')->with([
                'message' => trans('admin/user.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.users.index')->with([
                'message' => trans('admin/user.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        User::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.users.archive')->with([
            'message' => trans('admin/user.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.users.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                User::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.users.archive')->with([
            'message' => trans('admin/user.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.users.index')->with([
                'message' => trans('admin/user.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            User::destroy($ids);
        }else{
            User::find($ids)->delete();
        }
        return redirect()->route('admin.users.index')->with([
            'message' => trans('admin/user.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }

}
