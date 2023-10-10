<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'Board',
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

    function CreateUser($param, $userType){
        $data = (object) $param;
        return $this->create([
            "UserType" => $userType,
            "email" => $data->email,
            "Status" => "active",
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
}
