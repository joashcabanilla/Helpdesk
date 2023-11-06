<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentModel extends Model
{
    use HasFactory;
    protected $table = 'department';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Name',
    ];

    function getAllDepartment(){
        $result = array();
        foreach($this->get() as $data){
            $result[$data->Id] = [
                "id" => $data->Id,
                "name" => $data->Name
            ];
        }
        return $result;
    }
}
