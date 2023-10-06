<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

//Models
use App\Models\User;
use App\Models\UserTypeModel as UserType;

class UserController extends Controller
{

    protected $userModel, $userTypeModel; 

    public function __construct()
    {   
        $this->userModel = new User();
        $this->userTypeModel = new UserType();
    }

    function GmailSignUp(Request $request){
        $user = $this->userModel->CheckEmailExist($request->email);
        if($user){
            $this->userModel->UpdateUserLog($user->Id,Carbon::now(),$request->ip());
            return response()->json(["id" => $user->Id,"message" => "success"],200);
        }else{    
            $result = $this->userModel->CreateUser($request->all(),$this->userTypeModel->GetNewUserType()->TypeId);
            if($result){
                $this->userModel->UpdateUserLog($result->Id,Carbon::now(),$request->ip());
                return response()->json(["id" => $result->Id,"message" => "success"],200);
            }
        }

        return response('Gmail Authentication Error',500);
    }
}
