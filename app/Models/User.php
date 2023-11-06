<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'UserType',
        'Prefix',
        'FirstName',
        'MiddleName',
        'LastName',
        'Suffix',
        'Profile',
        'Branch',
        'Department',
        'MemberId',
        'EmployeeId',
        'Attemp',
        'email',
        'email_verified_at',
        'Verification',
        'username',
        'password',
        'Status',
        'LastLogin',
        'LastIp',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $branchModel, $departmentModel;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->branchModel = new BranchModel();
        $this->departmentModel = new DepartmentModel();
    }

    function CreateUser($param, $userType){
        $data = (object) $param;
        return $this->create([
            "UserType" => $userType,
            "email" => $data->email,
            "Status" => "active",
        ]);
    }

    function CreateUserVerify($param, $code, $userType){
        return $this->create([
            "UserType" => $userType,
            "email" => $param->email,
            "username" => $param->username,
            "password" => Hash::make($param->password),
            "Status" => "active",
            "Verification" => $code
        ]);
    }
    
    function CheckEmailExist($email){
        return $this->where('email',$email)->first();
    }

    function UpdateUserLog($id,$lastLogin,$lastIp){
        return $this->find($id)->update([
            "LastLogin" => $lastLogin,
            "LastIp" => $lastIp,
            "Attemp" => 0
        ]);
    }

    function generateToken($user){
        if(count($user->tokens) > 0){
            $user->tokens()->delete();
        }

        $access = "user";
        if($user->UserType == 1){
            $access = "admin";
        }
        
       return $user->createToken($user->email,[$access])->plainTextToken;
    }

    function updateVerificationCode($user, $code, $verifiedDate = ""){
        return $user->update([
            "Verification" => $code,
            "email_verified_at" => $verifiedDate == "" ? null : $verifiedDate
        ]);
    }

    function updateLoginCredentials($param){
        return $this->where("email",$param->email)->update([
            "username" => $param->username,
            "password" => Hash::make($param->password),
            "Status" => "active",
            "Attemp" => 0
        ]);
    }

    function getAllUser(){
        $result = array();
        $branch = $this->branchModel->getAllBranch();
        $department = $this->departmentModel->getAllDepartment();
        $user = $this->where("Status","active")->get();
        
        foreach($user as $data){
            $result[$data->Id] = [
                "usertype" => $data->UserType,
                "prefix" => $data->Prefix,
                "firstname" => ucwords(strtolower($data->FirstName)),
                "middlename" => ucwords(strtolower($data->MiddleName)),
                "lastname" => ucwords(strtolower($data->LastName)),
                "suffix" => $data->Suffix,
                "profile" => !empty($data->Profile) ? "data:image/jpeg;base64,".base64_encode($data->Profile) : null,
                "branch" => !empty($data->Branch) ? $branch[$data->Branch] : null,
                "department" => !empty($data->Department) ? $department[$data->Department] : null,
                "memberId" => $data->MemberId,
                "employeeId" => $data->EmployeeId,
                "email" => $data->email,
            ];
        }
        return $result;
    }
}
