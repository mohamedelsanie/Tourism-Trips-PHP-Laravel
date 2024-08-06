<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    //
    function __construct()
    {
        $this->middleware('permission:setting-edit,admin', ['only' => ['form','store']]);
    }

    public function form()
    {
        $setting = Setting::get()->first();
        $menus = Menu::all();
        $pages = Page::all();
//        dd($setting);
        return view('admin.settings.edit',['setting'=>$setting,'menus' => $menus,'pages' => $pages]);
    }

    public function store(Request $request)
    {
        $data = [
            'site_url'    => 'required',
        ];

        foreach (config('translatable.languages') as $key => $value) {
            $data[$key.'*.site_name'] = 'required|max:255|min:3|required';
        }

        $validator = Validator::make($request->all(), $data);
        if($validator->fails()){
//            dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        }

//        dd($request->all());
        $setting = Setting::find(1);
//
//        $setting->site_url = $request->site_url;
//        $setting->ar->site_name = $request->ar['site_name'];
//        $setting->en->site_name = $request->en['site_name'];
////
//        $setting->save();

        foreach (config('translatable.languages') as $key => $value) {
            if(empty($request->$key['slider'])){
                $setting->translate($key)->slider = '[]';
            }
            if(empty($request->$key['about_blocks'])){
                $setting->translate($key)->about_blocks = '[]';

            }
            if(empty($request->$key['about_sec3'])){
                $setting->translate($key)->about_sec3 = '[]';

            }
        }
        $setting->update($request->except( '_token'));

        return redirect()->route('admin.settings')->with([
            'message' => trans('admin/setting.saved'),
            'alert_type' => 'success'
        ]);

    }
}
