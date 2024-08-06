<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:order-list|order-create|order-edit|order-delete|order-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:order-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:order-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:order-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $pages = Order::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.orders.index',['pages'=>$pages]);
    }

    public function archive()
    {
        //
        $pages = Order::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.orders.archive',['pages'=>$pages]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $pages = Order::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.orders.index',['pages'=>$pages]);
        }else{
            return redirect()->route('admin.orders.index')->with([
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
        $users = User::all();
        $tours = Tour::all();
        $offers = Offer::all();
        return view('admin.orders.create',['users' => $users,'tours' => $tours,'offers' => $offers]);
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
            'title'     => 'required|max:255|min:3|required',
            'content'    => 'nullable',
            'amount'    => 'nullable',
            'tour_id'    => 'nullable',
            'offers'    => 'nullable',
            'from_date'    => 'nullable',
            'to_date'    => 'nullable',
            'from_place'    => 'nullable',
            'to_place'    => 'nullable',
            'user_id '    => 'nullable',
            'phone '    => 'nullable',
            'status'    => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $total = 0;
        if(!empty($request->offers)){
            foreach ($request->offers as $offer) {
                $offer_obj = Offer::find($offer);
                $price = $offer_obj->price;
                $total += $price;
            }
        }
        if(!empty($request->tour_id)){
            $tour_obj = Tour::find($request->tour_id);
            $price = $tour_obj->price;
            $total += $price;
        }

        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $data['amount'] = $request->amount;
        $data['tour_id'] = $request->tour_id;
        $data['offers'] = $request->offers;
        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['from_place'] = $request->from_place;
        $data['to_place'] = $request->to_place;
        $data['user_id'] = $request->user_id;
        $data['status'] = $request->status;
        $data['phone'] = $request->phone;
        $data['fin_price'] = ($total+$request->amount);

        Order::Create($data);

        return redirect()->route('admin.orders.index')->with([
            'message' => trans('admin/order.messages.created'),
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
        $order = Order::find($id);
        $users = User::all();
        $user = User::where('id',$order->user_id)->first();
        $tours = Tour::all();
        $tour = Tour::where('id',$order->tour_id)->first();
        $offers = Offer::all();
        return view('admin.orders.show',['order' => $order,'users' => $users,'tours' => $tours,'offers' => $offers,'user' => $user,'tour' => $tour]);
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
        $page = Order::find($id);
        $users = User::all();
        $tours = Tour::all();
        $offers = Offer::all();
        return view('admin.orders.edit',['page' => $page,'users' => $users,'tours' => $tours,'offers' => $offers]);
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
            'title'     => 'required|max:255|min:3|required',
            'content'    => 'nullable',
            'amount'    => 'nullable',
            'tour_id'    => 'nullable',
            'offers'    => 'nullable',
            'from_date'    => 'nullable',
            'to_date'    => 'nullable',
            'from_place'    => 'nullable',
            'to_place'    => 'nullable',
            'user_id '    => 'nullable',
            'phone '    => 'nullable',
            'status'    => 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $page = Order::find($id);
        $total = 0;
        if(!empty($request->offers)){
            foreach ($request->offers as $offer) {
                $offer_obj = Offer::find($offer);
                $price = $offer_obj->price;
                $total += $price;
            }
        }
        if(!empty($request->tour_id)){
            $tour_obj = Tour::find($request->tour_id);
            $price = $tour_obj->price;
            $total += $price;
        }

        $page->title = $request->title;
        $page->content = $request->content;
        $page->amount = $request->amount;
        $page->tour_id = $request->tour_id;
        $page->offers = $request->offers;
        $page->from_date = $request->from_date;
        $page->to_date = $request->to_date;
        $page->from_place = $request->from_place;
        $page->to_place = $request->to_place;
        $page->user_id = $request->user_id;
        $page->status = $request->status;
        $page->phone = $request->phone;
        $page->fin_price = ($total+$request->amount);
//        dd($data);

        $page->save();

        return redirect()->route('admin.orders.index')->with([
            'message' => trans('admin/order.messages.edited',['page' => $page->title]),
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
        $item = Order::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.orders.archive')->with([
                'message' => trans('admin/order.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.orders.index')->with([
                'message' => trans('admin/order.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Order::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.orders.archive')->with([
            'message' => trans('admin/order.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.orders.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Order::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.orders.archive')->with([
            'message' => trans('admin/order.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.orders.index')->with([
                'message' => trans('admin/order.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Order::destroy($ids);
        }else{
            Order::find($ids)->delete();
        }
        return redirect()->route('admin.orders.index')->with([
            'message' => trans('admin/order.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
