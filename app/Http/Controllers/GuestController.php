<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    function Login(){
        return view('Components.Login', $this->data);
    }

    function Register(){
        return view('Components.Register', $this->data);
    }

    function PostLogin(Request $request){
        Auth::loginUsingId($request->id,true);
        return response('login',200);
    }

}
