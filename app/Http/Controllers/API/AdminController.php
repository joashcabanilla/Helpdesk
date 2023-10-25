<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\Models\CategoryModel;
use App\Models\BranchModel;
use App\Models\DepartmentModel;
use App\Models\SubjectModel;

class AdminController extends Controller
{
    protected $ticketCategoryModel, $branchModel, $departmentModel, $subjectModel;

    public function __construct()
    {
        $this->ticketCategoryModel = new CategoryModel();
        $this->branchModel = new BranchModel();
        $this->departmentModel = new DepartmentModel();
        $this->subjectModel = new SubjectModel();   
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
}
