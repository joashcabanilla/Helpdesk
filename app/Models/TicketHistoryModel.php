<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'tickethistory';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
       'TicketId',
       'Status',
       'User'
    ];

    function CreateHistory($id, $status, $reporter){
        return $this->create([
            "TicketId" => $id,
            "Status" => $status,
            "User" =>  $reporter
        ]);
    }
}
