<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:tour-list|tour-create|tour-edit|tour-delete|tour-forcedelete,admin', ['only' => ['index','store']]);
        $this->middleware('permission:tour-create,admin', ['only' => ['create','store']]);
        $this->middleware('permission:tour-edit,admin', ['only' => ['edit','update']]);
        $this->middleware('permission:tour-delete,admin', ['only' => ['destroy','destroy_all']]);
        $this->middleware('permission:tour-forcedelete,admin', ['only' => ['archive','restore','restore_all']]);
    }

    public function index()
    {
        //
        $pages = Tour::orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.tours.index',['pages'=>$pages]);
    }

    public function archive()
    {
        //
        $pages = Tour::onlyTrashed()->orderBy('id','DESC')->paginate(admin_paginate());
        return view('admin.tours.archive',['pages'=>$pages]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        if(!empty($search)){
            $pages = Tour::orderBy('id','DESC')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('id', 'like', '%' . $search . '%')
                ->paginate(100);
            return view('admin.tours.index',['pages'=>$pages]);
        }else{
            return redirect()->route('admin.tours.index')->with([
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
        $categories = TourCategory::all();
        $offers = Offer::all();
        return view('admin.tours.create',['categories' => $categories,'offers' => $offers]);
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
            'slug'    => 'required|unique:tours,slug',
            'image'    => 'nullable',
            'from_date'    => 'nullable',
            'to_date'    => 'nullable',
            'price'    => 'required',
            'price_eg'    => 'required',
            'status'    => 'required',
            'category_id'    => 'required',
            'comments_status'    => 'nullable',
            'admin_id'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.content'] =  'nullable';
            $valid_data[$key.'*.description'] =  'nullable';
            $valid_data[$key.'*.from_place'] =  'nullable';
            $valid_data[$key.'*.to_place'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        foreach (config('translatable.languages') as $key => $value) {
            $data[$key]['title'] = $request->$key['title'];
            $data[$key]['content'] = $request->$key['content'];
            $data[$key]['description'] = $request->$key['description'];
            $data[$key]['from_place'] = $request->$key['from_place'];
            $data[$key]['to_place'] = $request->$key['to_place'];
        }


        $data['slug'] = $request->slug;
        $data['image'] = $request->image;
        $data['from_date'] = $request->from_date;
        $data['to_date'] = $request->to_date;
        $data['price'] = $request->price;
        $data['price_eg'] = $request->price_eg;
        $data['status'] = $request->status;
        $data['category_id'] = $request->category_id;
        $data['comments_status'] = $request->comments_status;
        $data['admin_id'] = $request->admin_id;

        $post = Tour::Create($data);

        $pid = $post->id;
        if($request->offers){
            foreach ($request->offers as $offer) {
                TourOffer::Create(['tour_id'=>$pid,'offer_id'=>$offer]);
            }
        }
        return redirect()->route('admin.tours.index')->with([
            'message' => trans('admin/tour.messages.created'),
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
        $page = Tour::find($id);
        return view('admin.tours.show',['page' => $page]);
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
        $tour = Tour::find($id);
        $categories = TourCategory::all();
        $offers = Offer::all();
        $post_offers = TourOffer::where(['tour_id' => $id])->get();
        $p_offers = $post_offers->pluck('offer_id')->toArray();
        return view('admin.tours.edit',['tour' => $tour,'categories' => $categories,'offers' => $offers,'post_offers' => $post_offers,'p_offers' => $p_offers]);
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
            'from_date'    => 'nullable',
            'to_date'    => 'nullable',
            'price'    => 'required',
            'price_eg'    => 'required',
            'status'    => 'required',
            'category_id'    => 'required',
            'comments_status'    => 'nullable',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $valid_data[$key.'*.title'] = 'required|max:255|min:3|required';
            $valid_data[$key.'*.content'] =  'nullable';
            $valid_data[$key.'*.description'] =  'nullable';
            $valid_data[$key.'*.from_place'] =  'nullable';
            $valid_data[$key.'*.to_place'] =  'nullable';
        }

        $validator = Validator::make($request->all(), $valid_data);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
//        dd($request->all());
        $page = Tour::find($id);

        foreach (config('translatable.languages') as $key => $value) {
            $page->translate($key)->title = $request->$key['title'];
            $page->translate($key)->content = $request->$key['content'];
            $page->translate($key)->description = $request->$key['description'];
            $page->translate($key)->from_place = $request->$key['from_place'];
            $page->translate($key)->to_place = $request->$key['to_place'];
        }

        $page->slug = $request->slug;
        $page->image = $request->image;
        $page->from_date = $request->from_date;
        $page->to_date = $request->to_date;
        $page->price = $request->price;
        $page->price_eg = $request->price_eg;
        $page->status = $request->status;
        $page->category_id = $request->category_id;
        $page->comments_status = $request->comments_status;
        $page->admin_id = $page->admin_id;
//        dd($data);

        $post_offers = TourOffer::where(['tour_id' => $id])->get();
        $offers = Offer::all();
        if(!empty(request('offers'))){
            foreach($offers as $offer){
                if(in_array($offer->id,request('offers'))){
                    $foc = TourOffer::updateOrCreate([
                        'tour_id' => $id,
                        'offer_id' => $offer->id,
                    ]);
                    $foc->save();
                }else{
                    $offer_post = TourOffer::where([
                        'tour_id' => $id,
                        'offer_id' => $offer->id,
                    ])->get();
                    if(!empty($offer_post )){
                        foreach($offer_post  as $offerp){
                            if(in_array($offerp->offer_id,request('offers'))){
                                $the_data = [
                                    'tour_id' => $id,
                                    'offer_id' => $offerp->offer_id,
                                ];
                                TourOffer::where([
                                    'tour_id' => $id,
                                    'offer_id' => $offerp->offer_id,
                                ])->update($the_data);
                            }else{
                                TourOffer::where([
                                    'tour_id' => $id,
                                    'offer_id' => $offerp->offer_id,
                                ])->delete();

                            }
                        }
                    }

                }
            }
        }else{
            TourOffer::where(['tour_id' => $id])->delete();
        }
        $page->save();

        return redirect()->route('admin.tours.index')->with([
            'message' => trans('admin/tour.messages.edited',['page' => $page->title]),
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
        $item = Tour::withTrashed()->find($id);
        if($item->trashed()){
            $item->forceDelete();
            return redirect()->route('admin.tours.archive')->with([
                'message' => trans('admin/tour.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }else{
            $item->delete();
            return redirect()->route('admin.tours.index')->with([
                'message' => trans('admin/tour.messages.deleted'),
                'alert_type' => 'success'
            ]);
        }
    }

    public function restore($id)
    {
        //
        Tour::onlyTrashed()->find($id)->restore();

        return redirect()->route('admin.tours.archive')->with([
            'message' => trans('admin/tour.messages.restored'),
            'alert_type' => 'success'
        ]);
    }


    public function restore_all(Request $request){
        $ids = $request->ids;
        if(empty($ids)){
            return redirect(route('admin.tours.archive'));
        }
        if(is_array($ids)){
            foreach ($ids as $id){
                Tour::onlyTrashed()->where('id', $id)->restore();
            }
        }else{
            //News::onlyTrashed()->find($ids)->restore();
        }
        return redirect()->route('admin.tours.archive')->with([
            'message' => trans('admin/tour.messages.restored_selected'),
            'alert_type' => 'success'
        ]);

    }
    public function destroy_all(Request $request)
    {
        //
        $ids = $request->ids;
        if(empty($ids)){
            return redirect()->route('admin.tours.index')->with([
                'message' => trans('admin/tour.messages.delete_empty'),
                'alert_type' => 'danger'
            ]);
        }
        if(is_array($ids)){
            Tour::destroy($ids);
        }else{
            Tour::find($ids)->delete();
        }
        return redirect()->route('admin.tours.index')->with([
            'message' => trans('admin/tour.messages.deleted_selected'),
            'alert_type' => 'success'
        ]);

    }
}
