<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Test extends Component
{

    public function render()
    {
        return view('admin.livewire.test');
    }
    public function test(){
        dd('test');
    }
}
