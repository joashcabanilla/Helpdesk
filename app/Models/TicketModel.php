<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

//Classes
use App\Classes\HelperClass;

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
        'Branch',
        'Department',
        'Attach0',
        'Attach1',
        'Attach2'
    ];

    protected $ticketCategoryModel, $branchModel, $departmentModel, $subjectModel, $helper, $userModel, $ticketHistoryModel;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->ticketCategoryModel = new CategoryModel();
        $this->branchModel = new BranchModel();
        $this->departmentModel = new DepartmentModel();
        $this->subjectModel = new SubjectModel();   
        $this->helper = new HelperClass();
        $this->userModel = new User();
        $this->ticketHistoryModel = new TicketHistoryModel();
    }

    function getTicket($id, $param){
        $result = array();
        $category = $this->ticketCategoryModel->getAllCategory();
        $subject = $this->subjectModel->getAllSubject();
        $user = $this->userModel->getAllUser();
        $ticketData = $this;

        if(isset($param['allStatus']) && !$param['allStatus']){
            $ticketData = $ticketData->whereNotIn("Status",[4,5]);
        }
        
        if(isset($param['ticketNo']) && !empty($param['ticketNo'])){
            $ticketNo = explode("-",$param['ticketNo']);
            if(count($ticketNo) == 2){
                $categoryId = 0;
                foreach($category as $catId => $cat){
                   if($cat["code"] == strtoupper($ticketNo[0])){
                        $categoryId = $catId;
                   }
                }

                if($categoryId != 0){
                    $ticketNum = (int) $ticketNo[1]; 
                     $ticketData = $ticketData->where("Category",$categoryId)->where("TicketNo",$ticketNum);            
                }
                
            }   
        }

        if(isset($param["branch"]) && !empty($param["branch"])){
            $ticketData = $ticketData->whereIn("Branch", $param["branch"]);
        }

        if(isset($param["department"]) && !empty($param["department"])){
            $ticketData = $ticketData->whereIn("Department", $param["department"]);
        }
        
        if(isset($param["category"]) && !empty($param["category"])){
            $ticketData = $ticketData->whereIn("Category", $param["category"]);
        }

        if(isset($param["subject"]) && !empty($param["subject"])){
            $ticketData = $ticketData->whereIn("Subject", $param["subject"]);
        }

        if(isset($param["level"]) && !empty($param["level"])){
            $ticketData = $ticketData->whereIn("PriorityLevel", $param["level"]);
        }

        if(isset($param["datefrom"]) && !empty($param["datefrom"])){
            $ticketData = $ticketData->where("created_at",">=",$param["datefrom"]);
        }

        if(isset($param["dateto"]) && !empty($param["dateto"])){
            $ticketData = $ticketData->where("created_at","<=",$param["dateto"]);
        }

        $ticketData = $id == 0 ? $ticketData->orderBy("Category")->orderBy("TicketNo")->get() : $ticketData->where("Id",$id)->get();

        if(!empty($ticketData)){
            foreach($ticketData as $ticket){
                $ticketNo = $ticket->TicketNo <= 999 ? sprintf('%03d', $ticket->TicketNo) : $ticket->TicketNo;
                $ticketNoLabel = $category[$ticket->Category]["code"]."-". $ticketNo;
                if(isset($user[$ticket->Reporter])){
                    $result[] = [
                        "id" => $ticket->Id,
                        "ticketNo" => $ticket->TicketNo,
                        "ticketNoLabel" => $ticketNoLabel,
                        "category" => $category[$ticket->Category],
                        "subject" => $subject[$ticket->Subject],
                        "description" => $ticket->Description,
                        "priorityLevel" => [
                            "value" => $ticket->PriorityLevel,
                            "label" => $this->helper->ticketLevel()[$ticket->PriorityLevel]
                        ],
                        "status" => [
                            "value" => $ticket->Status,
                            "label" => $this->helper->ticketStatus()[$ticket->Status]
                        ],
                        "assignee" => !empty($ticket->Assignee) && isset($user[$ticket->Assignee]) ? $user[$ticket->Assignee] : null,
                        "reporter" => $user[$ticket->Reporter],
                        "attach" => [
                            0 => !empty($ticket->Attach0) ? "data:image/jpeg;base64,".base64_encode($ticket->Attach0) : null,
    
                            1 => !empty($ticket->Attach1) ? "data:image/jpeg;base64,".base64_encode($ticket->Attach1) : null,
    
                            2 => !empty($ticket->Attach2) ? "data:image/jpeg;base64,".base64_encode($ticket->Attach2) : null,
                        ],
                        "date" => date("F j, Y", strtotime($ticket->created_at)) ." at ". date("g:i A", strtotime($ticket->created_at))
                    ];
                }
            }
        }
        return $result;
    }
    
    function CreateTicket($data){
        $ticketNo = $this->where("Category", $data->category)->max('TicketNo');
        $ticketNo = !empty($ticketNo) ? $ticketNo+=1 : 1;
        $ticket = [
            'TicketNo' => $ticketNo,
            'Category' => $data->category,
            'Subject' => $data->subject,
            'Description' => $data->description,
            'PriorityLevel' => $data->level,
            'Reporter' => Auth::user()->Id,
            'Branch' => Auth::user()->Branch,
            'Department' => Auth::user()->Department
        ];
        if(!empty($data->file('attachImage'))){
            $files = $data->file('attachImage');
            foreach($files as $index => $file){
                $ticket["Attach" . $index] = file_get_contents($file->getRealPath());
            }
        }

        $ticket = $this->create($ticket);
        $this->ticketHistoryModel->CreateHistory($ticket->Id, 1, $ticket->Reporter);
        return $ticket;
    }

    function UpdateTicket($data){
        $ticket = [
            'Category' => $data->category,
            'Subject' => $data->subject,
            'Description' => $data->description,
            'PriorityLevel' => $data->level
        ];

        if(!empty($data->file('attachImage'))){
            $files = $data->file('attachImage');
            foreach($files as $index => $file){
                $ticket["Attach" . $index] = file_get_contents($file->getRealPath());
            }
        }

        $attachment = ["Attach0","Attach1","Attach2"];
        foreach($attachment as $attach){
            if(!isset($ticket[$attach])){
                $ticket[$attach] = null;
            }
        }

        $ticketData = $this->find($data->ticketId);
        if($ticketData->Category != $data->category){
            $ticketNo = $this->where("Category", $data->category)->max('TicketNo');
            $ticketNo = !empty($ticketNo) ? $ticketNo+=1 : 1;
            $ticket["TicketNo"] = $ticketNo;
        }

        return $this->find($data->ticketId)->update($ticket);
    }

    function DeleteTicket($data){
        return $this->find($data->id)->delete();
    }

    function UpdateTicketStatus($data){
        $this->ticketHistoryModel->CreateHistory($data->id, $data->status, Auth::user()->Id);
       return $this->find($data->id)->update(["Status" => $data->status]);
    }
}
