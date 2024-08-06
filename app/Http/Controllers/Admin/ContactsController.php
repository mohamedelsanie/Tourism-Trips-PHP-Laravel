<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:contact-list|contact-create|contact-edit|contact-delete|contact-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:contact-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:contact-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:contact-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:contact-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $pages = Contact::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.contacts.index',['pages'=>$pages]);
    }

    public function archive()
    {
        //
        $pages = Contact::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.contacts.archive',['pages'=>$pages]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $pages = Contact::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.contacts.index',['pages'=>$pages]);
        }else{
            return redirect()->route('admin.contacts.index')->with([
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
        return view('admin.contacts.create');
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
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'from_name'     => 'required|max:255|min:3|required',
            'from_email'    => 'required',
            'subject'    => 'nullable',
            'massege'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['from_name'] = $request->from_name;
        $data['from_email'] = $request->from_email;
        $data['subject'] = $request->subject;
        $data['massege'] = $request->massege;

        Contact::Create($data);

        return redirect()->route('admin.contacts.index')->with([
            'message' => trans('admin/contact.messages.created'),
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
        $page = Contact::find($id);
        return view('admin.contacts.show',['page' => $page]);
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
        $page = Contact::find($id);
        return view('admin.contacts.edit',['page' => $page]);
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
            'from_name'     => 'required|max:255|min:3|required',
            'from_email'    => 'required',
            'subject'    => 'nullable',
            'massege'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $page = Contact::find($id);

        $page->from_name = $request->from_name;
        $page->from_email = $request->from_email;
        $page->subject = $request->subject;
        $page->massege = $request->massege;
        $page->save();

        return redirect()->route('admin.contacts.index')->with([
            'message' => trans('admin/contact.messages.edited',['page' => $page->subject]),
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
        $item = Contact::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.contacts.archive')->with([
                'message' => trans('admin/contact.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.contacts.index')->with([
                'message' => trans('admin/contact.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Contact::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.contacts.archive')->with([
            'message' => trans('admin/contact.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.contacts.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Contact::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.contacts.archive')->with([
            'message' => trans('admin/contact.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.contacts.index')->with([
                'message' => trans('admin/contact.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Contact::destroy($ids);
        }else{
            Contact::find($ids)->delete();
        }
        return redirect()->route('admin.contacts.index')->with([
            'message' => trans('admin/contact.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
