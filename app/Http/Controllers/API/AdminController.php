<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\Models\BoardModel;
use App\Models\BranchModel;
use App\Models\DepartmentModel;
use App\Models\SubjectModel;

class AdminController extends Controller
{
    protected $boardModel, $branchModel, $departmentModel, $ticketCategoryModel;

    public function __construct()
    {
        $this->boardModel = new BoardModel();
        $this->branchModel = new BranchModel();
        $this->departmentModel = new DepartmentModel();
        $this->ticketCategoryModel = new SubjectModel();   
    }

    function GetBoardData(Request $request, $id){
        if($id == 0){
            return response()->json($this->boardModel->get(),200);
        }else{
            return response()->json($this->boardModel->find($id),200);
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
            return response()->json($this->ticketCategoryModel->get(),200);
        }else{
            return response()->json($this->ticketCategoryModel->find($id),200);
        }
    }
}
