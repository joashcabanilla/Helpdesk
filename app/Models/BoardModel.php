<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardModel extends Model
{
    use HasFactory;
    protected $table = 'board';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'Name',
    ];
}
