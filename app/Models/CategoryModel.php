<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'ticketcategory';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Name',
        'Code'
    ];

    function subjects(){
        return $this->hasMany(SubjectModel::class, "Category");
    }

    function getAllCategory(){
        $result = array();
        foreach($this->get() as $data){
            $result[$data->Id] = [
                "code" => $data->Code,
                "name" => $data->Name
            ];
        }
        return $result;
    }
}
