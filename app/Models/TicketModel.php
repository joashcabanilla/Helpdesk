<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'Attach0',
        'Attach1',
        'Attach2'
    ];

    function CreateTicket($data){
        $ticketNo = $this->where("Category", $data->category)->max('TicketNo');
        $ticketNo = !empty($ticketNo) ? $ticketNo+=1 : 1;
        $ticket = [
            'TicketNo' => $ticketNo,
            'Category' => $data->category,
            'Subject' => $data->subject,
            'Description' => $data->description,
            'Reporter' => Auth::user()->Id,
        ];
        if(!empty($data->file('attachImage'))){
            $files = $data->file('attachImage');
            foreach($files as $index => $file){
                $ticket["Attach" . $index] = file_get_contents($file->getRealPath());
            }
        }

        return $this->create($ticket);
    }
}
