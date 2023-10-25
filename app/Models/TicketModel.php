<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model
{
    use HasFactory;
    protected $table = 'ticket';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'TicketNo',
        'Category',
        'Subject',
        'Description',
        'PriorityLevel',
        'Status',
        'Assignee',
        'Reporter',
        'Attach1',
        'Attach2',
        'Attach3'
    ];
}
