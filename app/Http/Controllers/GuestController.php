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

    public function index(){
        return view('Components.Login', $this->data);
    }

}
