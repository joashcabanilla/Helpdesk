<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

//Models
use App\Models\User;
use App\Models\UserTypeModel as UserType;

class AuthController extends Controller
{
    protected $userModel, $userTypeModel; 

    public function __construct()
    {   
        $this->userModel = new User();
        $this->userTypeModel = new UserType();
    }

    function Register(Request $request){
        if($request->action == "gmail"){
            return $this->GmailSignUp($request);
        }else{

        }
    }

    private function GmailSignUp($request){
        $user = $this->userModel->CheckEmailExist($request->email);
        if($user){
            $this->userModel->UpdateUserLog($user->Id,Carbon::now(),$request->ip());
            $token = $this->userModel->generateToken($user);
            return response()->json(["id" => $user->Id, "token" => $token, "message" => "success"],200);
        }else{    
            $result = $this->userModel->CreateUser($request->all(),$this->userTypeModel->GetNewUserType()->TypeId);
            if($result){
                $this->userModel->UpdateUserLog($result->Id,Carbon::now(),$request->ip());
                $token = $this->userModel->generateToken($result);
                return response()->json(["id" => $result->Id,"token" => $token, "message" => "success"],200);
            }
        }

        return response('Gmail Authentication Error',500);
    }
}
