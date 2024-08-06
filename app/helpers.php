<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\MenuLinks;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\NewsTag;
use App\Models\Page;
use App\Models\Image;
use App\Models\Video;
use App\Models\Tour;
use App\Models\User;
use App\Models\TourCategory;


if(! function_exists('AdminName')){
    function AdminName(){
        return Auth::guard('admin')->user()->name;
    }
}

if(! function_exists('UserName')){
    function UserName(){
        return Auth::user()->name;
    }
}

if(! function_exists('AdminCan')){
    function AdminCan($permission){
        return auth()->guard('admin')->user()->can($permission);
    }
}

if(! function_exists('AdminId')){
    function AdminId(){
        return Auth::guard('admin')->user()->id;
    }
}

if(! function_exists('userAvater')){
    function userAvater($user_id){
        $user = User::where('id',$user_id)->first();
        if(!$user){
            return asset('assets/front/img/core-img/avater.png');
        }else{
            return $user->image;
        }
    }
}

if(! function_exists('admin_paginate')){
    function admin_paginate(){
        $settings = Setting::checkSetting();
        return $settings->admin_paginate;
    }
}

if(! function_exists('getPrice')){
    function getPrice($price){
        return $price.' '.getSetting('currency');
    }
}

if(! function_exists('getEgPrice')){
    function getEgPrice($price){
        return $price;
    }
}

if(! function_exists('getSetting')){
    function getSetting($val){
        $settings = Setting::checkSetting();
        return $settings->$val;
    }
}


if(! function_exists('getMenu')){
    function getMenu($id){
        $menu = \App\Models\Menu::where('id',$id)->first();
        $menu_links = MenuLinks::where('menu_id',$id)->get();
        $menuitems = '';
        $jc = $menu->content ?? '[{}]';
        $menuitems = json_decode($jc);
        $menuitems = $menuitems[0];
        $content = [];
		if(!empty($menu->content)){
		    //dd($menuitems);
                foreach($menuitems as $menu){
                    $menu->title = MenuLinks::find(['id',$menu->id])->value('title');
                    $menu->name = MenuLinks::find(['id',$menu->id])->value('name');
                    $menu->slug = MenuLinks::find(['id',$menu->id])->value('slug');
                    $menu->target = MenuLinks::find(['id',$menu->id])->value('target');
                    $menu->type = MenuLinks::find(['id',$menu->id])->value('type');
                if($menu->type == 'post'){$menu->link = getNewsLink($menu->slug);}
                elseif($menu->type == 'category'){$menu->link = getCatLink($menu->slug);}
                elseif($menu->type == 'tour_category'){$menu->link = getTourCatLink($menu->slug);}
                elseif($menu->type == 'tour'){$menu->link = getTourLink($menu->slug);}
                else{$menu->link = $menu->slug;}
                    if(!empty($menu->children[0])){
                        foreach ($menu->children[0] as $child) {
                            $child->title = MenuLinks::find(['id',$child->id])->value('title');
                            $child->name = MenuLinks::find(['id',$child->id])->value('name');
                            $child->slug = MenuLinks::find(['id',$child->id])->value('slug');
                            $child->target = MenuLinks::find(['id',$child->id])->value('target');
                            $child->type = MenuLinks::find(['id',$child->id])->value('type');
                        if($child->type == 'post'){$child->link = getNewsLink($child->slug);}
                        elseif($child->type == 'category'){$child->link = getCatLink($child->slug);}
                        elseif($child->type == 'tour_category'){$child->link = getTourCatLink($child->slug);}
                        elseif($child->type == 'tour'){$child->link = getTourLink($child->slug);}
                        else{$child->link = $child->slug;}
                        }
                    }
                }
		}else{
		    $menuitems = MenuLinks::where('menu_id',$id)->get();
		}
        return $menuitems;
    }
}

if(! function_exists('getCatLink')){
    function getCatLink($slug){
        $category = NewsCategory::where('slug',$slug)->first();
		if($category){
			return route('category',$category->slug);
		}
    }
}

if(! function_exists('getPageLink')){
    function getPageLink($id){
        $page = Page::where('id',$id)->first();
		if($page){
			return route('page',$page->slug);
		}
    }
}

if(! function_exists('getNewsLink')){
    function getNewsLink($slug){
        $post = News::where('slug',$slug)->first();
		if($post){
			return route('post',$post->slug);
		}
    }
}

if(! function_exists('getImageLink')){
    function getImageLink($slug){
        $post = Image::where('slug',$slug)->first();
		if($post){
			return route('photo',$post->slug);
		}
    }
}

if(! function_exists('getVideoLink')){
    function getVideoLink($slug){
        $post = Video::where('slug',$slug)->first();
		if($post){
			return route('video',$post->slug);
		}
    }
}

if(! function_exists('getTourLink')){
    function getTourLink($slug){
        $post = Tour::where('slug',$slug)->first();
		if($post){
			return route('tour',$post->slug);
		}
    }
}

if(! function_exists('getTourCatLink')){
    function getTourCatLink($slug){
        $category = TourCategory::where('slug',$slug)->first();
		if($category){
			return route('tours.category',$category->slug);
		}
    }
}

if(! function_exists('activeMenu')){
    function activeMenu($uri = '',$uri_en = '') {
        $active = '';
        if (Request::is(Request::segment(1) . '/' .Request::segment(2) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' .Request::segment(2) . '/' . $uri) || Request::is($uri)) {
            $active = 'active';
        }elseif (Request::is(Request::segment(1) . '/' .Request::segment(2) . '/' . $uri_en . '/*') || Request::is(Request::segment(1) . '/' .Request::segment(2) . '/' . $uri_en) || Request::is($uri_en)){
            $active = 'active';
        }
        return $active;
    }
}

if(! function_exists('getCookie')){
    function getCookie($value){
        $var = Request::cookie($value);
        return $var;
    }
}

if(! function_exists('recentNews')){
    function recentNews($limit){
        $posts = News::where(['status' => 'publish'])->orderBy('id','DESC')->offset(0)->take($limit)->get();
        return $posts;
    }
}

if(! function_exists('recenttags')){
    function recenttags($limit){
        $tags = NewsTag::orderBy('id','DESC')->offset(0)->take($limit)->get();
        return $tags;
    }
}

if(! function_exists('recentImages')){
    function recentImages($limit){
        $images = Image::where(['status' => 'publish'])->orderBy('id','DESC')->offset(0)->take($limit)->get();
        return $images;
    }
}

if(! function_exists('recentVideos')){
    function recentVideos($limit){
        $videos = Video::where(['status' => 'publish'])->orderBy('id','DESC')->offset(0)->take($limit)->get();
        return $videos;
    }
}

if(! function_exists('latestnews')){
    function latestnews(){
        $news = News::where(['status' => 'publish'])->orderBy('id','DESC')->offset(0)->take(getSetting('footer_blog_count'))->get();
        return $news;
    }
}
