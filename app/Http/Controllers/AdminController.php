<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function AdminPage(){
        return view('Layouts.Admin');
    }
    
    function TicketBoard(){
        return view('Components.Admin.TicketBoard');
    }

    function TicketList(){
        return view('Components.Admin.TicketList');
    }

    function Category(){
        return view('Components.Admin.Category');
    }

    function Department(){
        return view('Components.Admin.Department');
    }

    function Branch(){
        return view('Components.Admin.Branch');
    }

    function Subject(){
        return view('Components.Admin.Subject');
    }

    function Admin(){
        return view('Components.Admin.Admin');
    }

    function Employee(){
        return view('Components.Admin.Employee');
    }

    function Member(){
        return view('Components.Admin.Member');
    }

    function ManageAccount(){
        return view('Components.Admin.ManageAccount');
    }

    function Report(){
        return view('Components.Admin.Report');
    }

    function Setting(){
        return view('Components.Admin.Setting');
    }
}
