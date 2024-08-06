<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Hash;
use App\Models\User;

class LoginRegister extends Component
{
    public $users, $email, $password, $name, $phone_code, $phone, $page;
    public $registerForm = false;

    public function render()
    {
        return view('livewire.login-register');
    }
    public function mount($page)
    {
        $this->page = $page;
    }
    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone_code = '';
        $this->phone = '';
    }

    public function login()
    {
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(\Auth::attempt(array('email' => $this->email, 'password' => $this->password))){
            session()->flash('message', "You are Login successful.");
//            return redirect($this->page);
        }else{
            session()->flash('error', 'email and password are wrong.');
        }
    }

    public function register()
    {
        $this->registerForm = !$this->registerForm;
    }

    public function registerStore()
    {
        $validatedDate = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone_code' => 'required',
            'phone' => 'required',
        ]);

        $this->password = Hash::make($this->password);

        $user = User::create(['name' => $this->name, 'email' => $this->email,'password' => $this->password,'phone_code' => $this->phone_code,'phone' => $this->phone]);
        \Auth::login($user);
        session()->flash('message', "You are Login successful.");
        $this->resetInputFields();

    }
}