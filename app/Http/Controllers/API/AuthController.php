<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;


//Models
use App\Models\User;
use App\Models\UserTypeModel as UserType;

//Mail
use App\Mail\VerifyAccount;

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
            return $this->FormSignUp($request);
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

    private function FormSignUp($request){
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255','email:rfc,dns','unique:users'],
            'username' => ['required', 'string', 'min:5','unique:users'],
            'password' => ['required','string', 'min:8', 'confirmed'],
        ];

        $validator = Validator::make($request->all(),$rules);

        $result["status"] = "success";
        
        if($validator->fails()){
            $result["error"] = $validator->errors();
            $result["status"] = "failed";
        }else{
            $verificationCode = mt_rand(100000, 999999);

            $user = $this->userModel->CreateUserVerify($request,$verificationCode,$this->userTypeModel->GetNewUserType()->TypeId);

            if($user){
                $result["email"] = $user->email;
                $emailData = [
                    'code' => $verificationCode,
                    'email' => $user->email
                ];
                Mail::to($user->email)->send(new VerifyAccount($emailData));

            }else{
                return response("database error",500);
            }
        }

        return response()->json($result, 200);
    }

    function ResendOTP(Request $request){
        $result = [
            "message" => "The OTP has been successfully resent.", 
        ];

        $user = $this->userModel->CheckEmailExist($request->email);

        if($user){
            $verificationCode = mt_rand(100000, 999999);
            $emailData = [
                'code' => $verificationCode,
                'email' => $user->email
            ];
            Mail::to($user->email)->send(new VerifyAccount($emailData));
            $this->userModel->updateVerificationCode($user,$verificationCode);
            $response = response()->json($result, 200);
        }else{
            $result["message"] = "Email not found.";
            $response = response()->json($result, 202);
        }

        return $response;
    }

    function VerifyOTP(Request $request){
        $result = [
            "message" => "Email successfully verified.", 
        ];

        $user = $this->userModel->CheckEmailExist($request->email);

        if($user){
            if($user->Verification == $request->otp && $user->Verification != 0){
                $this->userModel->updateVerificationCode($user,0,Carbon::now());
                $response = response()->json($result, 200);
            }else{
                $result["message"] = "Incorrect OTP.";
                $response = response()->json($result, 202);
            }

        }else{
            $result["message"] = "Email not found.";
            $response = response()->json($result, 202);
        }
        
        return $response;
    }

    function SearchEmail(Request $request){
        $result = [
            "message" => "The email has been successfully found.", 
        ];

        $user = $this->userModel->CheckEmailExist($request->email);

        if($user){
            $response = response()->json($result, 200);
        }else{
            $result["message"] = "Email not found.";
            $response = response()->json($result, 202);
        }

        return $response;
    }

    function UpdateLoginCredentials(Request $request){
        $result = [
            "message" => "Successfully updated.", 
        ];

        $rules = [
            'username' => ['required', 'string', 'min:5','unique:users'],
            'password' => ['required','string', 'min:8', 'confirmed'],
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $result["message"] = "Invalid Data.";
            $result["error"] = $validator->errors();
            $response = response()->json($result, 202);
        }else{
            $user = $this->userModel->updateLoginCredentials($request);
            if($user){
                $response = response()->json($result, 200);
            }else{
                $result["message"] = "SQL Database Error";
                $response = response()->json($result, 500);
            }
        }
        return $response;
    }
}
