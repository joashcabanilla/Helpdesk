<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;
    protected $table = 'ticketsubject';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Name',
        'Category'
    ];

    function categories(){
        return $this->belongsTo(CategoryModel::class, 'Id');
    }

    function getAllSubject(){
        $result = array();
        foreach($this->get() as $data){
            $result[$data->Id] = [
                "category" => $data->Category,
                "name" => $data->Name,
                "value" => $data->Id
            ];
        }
        return $result;
    }
}
