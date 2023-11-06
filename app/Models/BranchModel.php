<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchModel extends Model
{
    use HasFactory;
    protected $table = 'branch';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Name',
    ];

    function getAllBranch(){
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
