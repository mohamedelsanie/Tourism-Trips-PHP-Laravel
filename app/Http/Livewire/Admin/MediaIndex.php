<?php

namespace App\Http\Livewire\Admin;

use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MediaIndex extends Component
{
    use WithPagination;
    protected $listeners = ['refreshMediaGallery' => '$refresh'];
    public $all_media;
    public $all_media2;
    public $uploader;
    public function refresh()
    {
//        $media = Media::orderBy('id','DESC')->paginate(4);
//        $links = $media->links();
//        $this->all_media = collect($media->items());
////        $this->render();
//        session()->flash('message', 'Rereshed .');
    }

    public function render()
    {
        $admin = Auth::guard('admin')->user()->can('movie-forcedelete');
        if($admin){
            $media = Media::orderBy('id','DESC')->paginate(admin_paginate());
        }else{
            $media = Media::orderBy('id','DESC')->where(['admin_id' => AdminId()])->paginate(admin_paginate());
        }

        $links = $media->onEachSide(1)->links();
        $this->all_media = collect($media->items());
        return view('livewire.admin.media-index',['media'=>$media,'links'=>$links]);
    }
}
