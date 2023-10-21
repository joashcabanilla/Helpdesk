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

    function TicketHistory(){
        return view('Components.Admin.TicketHistory');
    }

    function Board(){
        return view('Components.Admin.Board');
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
