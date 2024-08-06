<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Media;

class FileUploader extends Component
{
    use WithFileUploads;

    public $photo;
//    public $file;
    public $uploader;
    public $tfield2;

    public function mount($field)
    {
        $this->tfield2 = $field;
    }
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:5120', // 1MB Max
        ]);
    }
    public function save()
    {
        $this->validate([
            'photo' => 'image|max:5120', // 1MB Max
        ]);

//            dd($this->photo);


//        $request->file->move(public_path('file'), $fileName);


        $this->photo->store('photos');


        $data['file_name'] = $this->photo->store('photos');
        $data['responsive_images'] = '';
        $data['admin_id'] = \Auth::guard('admin')->user()->id;

        Media::Create($data);

        $this->photo = '';
        session()->flash('message', 'Image successfully Uploaded.');
        $media = Media::latest('created_at')->get()->first();

        session()->flash('image', $media->file_name);
        $this->emit('refreshMediaGallery');

    }

    public function remove()
    {
        $this->photo = '';
    }

    public function update(){

//        $this->render();
    }

    public function render()
    {
        return view('livewire.admin.file-uploader',['field' => $this->tfield2]);
    }
}
