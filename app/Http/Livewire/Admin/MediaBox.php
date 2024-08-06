<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class MediaBox extends Component
{
    public $modal;
    public $showUploader;
    public $showGallery;
    public $tfield;

    public function mount($field)
    {
        $this->showUploader = false;
        $this->showGallery = false;
        $this->tfield = $field;
    }

    public function uploaderStatue(){
        if($this->showUploader == false){
            $this->showUploader = true;
        }else{
            $this->showUploader = true;
        }
    }
    public function galleryStatue(){
        if($this->showGallery == false){
            $this->showGallery = true;
        }else{
            $this->showGallery = true;
        }
    }
    public function render()
    {
        return view('livewire.admin.media-box',['field' => $this->tfield]);
    }


}
