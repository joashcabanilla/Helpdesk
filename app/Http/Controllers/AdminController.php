<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $data;

    public function __construct()
    {
        $this->middleware('auth');
        $this->data = array();
    }

    function AdminPage(){
        $this->data['tabTitle'] = "TICKET BOARD";
        return view('Layouts.Admin', $this->data);
    }
    
    function TicketBoard(){
        return view('Components.Admin.TicketBoard',$this->data);
    }

    function TicketHistory(){
        return view('Components.Admin.TicketHistory',$this->data);
    }

    function Department(){
        return view('Components.Admin.Department',$this->data);
    }

    function Branch(){
        return view('Components.Admin.Branch',$this->data);
    }

    function Ticket(){
        return view('Components.Admin.Ticket',$this->data);
    }

    function Admin(){
        return view('Components.Admin.Admin',$this->data);
    }

    function Employee(){
        return view('Components.Admin.Employee',$this->data);
    }

    function Member(){
        return view('Components.Admin.Member',$this->data);
    }

    function ManageAccount(){
        return view('Components.Admin.ManageAccount',$this->data);
    }

    function Report(){
        return view('Components.Admin.Report',$this->data);
    }

    function Setting(){
        return view('Components.Admin.Setting',$this->data);
    }
}
