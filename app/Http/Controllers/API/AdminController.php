<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Classes
use App\Classes\HelperClass;

//Models
use App\Models\CategoryModel;
use App\Models\BranchModel;
use App\Models\DepartmentModel;
use App\Models\SubjectModel;
use App\Models\TicketModel;
use App\Models\User;

class AdminController extends Controller
{
    protected $ticketCategoryModel, $branchModel, $departmentModel, $subjectModel, $ticketModel, $helper, $userModel;

    public function __construct()
    {
        $this->ticketCategoryModel = new CategoryModel();
        $this->branchModel = new BranchModel();
        $this->departmentModel = new DepartmentModel();
        $this->subjectModel = new SubjectModel();   
        $this->ticketModel = new TicketModel();
        $this->helper = new HelperClass();
        $this->userModel = new User();
    }

    function GetCategoryData(Request $request, $id){
        if($id == 0){
            return response()->json($this->ticketCategoryModel->get(),200);
        }else{
            return response()->json($this->ticketCategoryModel->find($id),200);
        }
    }

    function GetBranchData(Request $request, $id){
        if($id == 0){
            return response()->json($this->branchModel->get(),200);
        }else{
            return response()->json($this->branchModel->find($id),200);
        }
    }

    function GetDepartmentData(Request $request, $id){
        if($id == 0){
            return response()->json($this->departmentModel->get(),200);
        }else{
            return response()->json($this->departmentModel->find($id),200);
        }
    }

    function GetSubjectData(Request $request, $id){
        if($id == 0){
            if(!empty($request->all())){
                return response()->json($this->subjectModel->whereIn("Category", $request->category)->get(), 200);
            }
            return response()->json($this->subjectModel->get(),200);
        }else{
            return response()->json($this->subjectModel->find($id),200);
        }
    }

    function CreateTicket(Request $request){
        $result = $this->ticketModel->CreateTicket($request);
        if($result){
            return response("Ticket Successfully Created.",200);
        }
        return response('Database Error',500);
    }

    function GetTicketData(Request $request, $id){
        $result = $this->ticketModel->getTicket($id, $request->all());
        if(!empty($result)){
            return response()->json($result,200);
        }
        return response('No Data Found',202);
    }
}
