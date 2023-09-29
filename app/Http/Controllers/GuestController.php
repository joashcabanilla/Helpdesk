<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class GuestController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->middleware('guest');
        $this->data = array();
    }

    public function Login(){
        return view('Components.Login', $this->data);
    }

    public function Register(){
        return view('Components.Register', $this->data);
    }

}
