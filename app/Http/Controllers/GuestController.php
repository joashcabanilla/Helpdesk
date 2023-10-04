<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\Models\SettingModel;

class GuestController extends Controller
{
    protected $data, $settingModel;

    public function __construct()
    {
        $this->middleware('guest');
        $this->data = array();
        $this->settingModel = new SettingModel();
        $this->data['terms'] = $this->settingModel->getDescription('terms');
    }

    //controller functions for viewing page.
    public function Login(){
        return view('Components.Login', $this->data);
    }

    public function Register(){
        return view('Components.Register', $this->data);
    }

    //controller functions for process.
    public function SignUp(Request $request){
        
    }
}
