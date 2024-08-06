<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Media;
use Livewire\WithPagination;

class MediaGallery extends Component
{
    use WithPagination;
    public $all_media;
    public $all_media2;
    public $uploader;
    protected $listeners = ['refreshMediaGallery' => '$refresh'];
    public function gallery()
    {
        $media = Media::orderBy('id','DESC')->get();
    }


    public function refresh()
    {
//        $media = Media::orderBy('id','DESC')->paginate(4);
//        $links = $media->links();
//        $this->all_media = collect($media->items());
////        $this->render();
//        session()->flash('message', 'Rereshed .');
    }

    public function render(): View
    {

//        return view('livewire.admin.media-gallery');
        $admin = Auth::guard('admin')->user()->can('movie-forcedelete');
        if($admin){
            $media = Media::orderBy('id','DESC')->paginate(admin_paginate());
        }else{
            $media = Media::orderBy('id','DESC')->where(['admin_id' => AdminId()])->paginate(admin_paginate());
        }
        $links = $media->onEachSide(1)->links();
        $this->all_media = collect($media->items());
        return view('livewire.admin.media-gallery', ['media'=>$this->all_media,'links'=>$links]);

    }
}
