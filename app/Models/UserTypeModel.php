<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypeModel extends Model
{
    use HasFactory;

    protected $table = 'usertype';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
       'TypeId',
       'UserType',
       'Status'
    ];

    function GetNewUserType(){
        return $this->where("UserType","new user")->first();
    }
}
