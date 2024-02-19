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
            $ticketData = $ticketData->whereDate("created_at",">=",$param["datefrom"]);
        }

        if(isset($param["dateto"]) && !empty($param["dateto"])){
            $ticketData = $ticketData->whereDate("created_at","<=",$param["dateto"]);
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
        $ticket = $this->find($data->id);

        if(Auth::user()->UserType == 1 || $ticket->Assignee == Auth::user()->Id){
            $this->ticketHistoryModel->CreateHistory($data->id, $data->status, Auth::user()->Id);
            return $ticket->update(["Status" => $data->status]);
        }
        
        return false;
    }

    function ticketDataTable($param){
        $result = array();
        $category = $this->ticketCategoryModel->getAllCategory();
        $subject = $this->subjectModel->getAllSubject();
        $branch = $this->branchModel->getAllBranch();
        $department = $this->departmentModel->getAllDepartment();
        $user = $this->userModel->getAllUser();
        $status = $this->helper->ticketStatus();

        $result["query"] = $this->select("ticket.Id","ticket.TicketNo","ticket.Category","ticket.Subject","ticket.Description","ticket.PriorityLevel","ticket.Status","ticket.Assignee","ticket.Reporter","ticket.Branch","ticket.Department","users.FirstName","users.LastName")->join("users","users.Id","ticket.Reporter");

        if(isset($param->searchTicket) && !empty($param->searchTicket)){
            $ticketNo = explode("-",$param->searchTicket);
            if(count($ticketNo) == 2){
                $categoryId = 0;
                foreach($category as $catId => $cat){
                   if($cat["code"] == strtoupper($ticketNo[0])){
                        $categoryId = $catId;
                   }
                }

                if($categoryId != 0){
                    $ticketNum = (int) $ticketNo[1]; 
                    $result["query"] = $result["query"]->where("ticket.Category",$categoryId)->where("ticket.TicketNo",$ticketNum);            
                }
            }else{   
                $result["query"] = $result["query"]->whereRaw("users.FirstName LIKE '%" . $param->searchTicket . "%'");

                $result["query"] = $result["query"]->orWhereRaw("users.LastName LIKE '%" . $param->searchTicket . "%'");
            }
        }

        if(isset($param->branch) && !empty($param->branch)){
            $result["query"] = $result["query"]->whereIn("ticket.Branch", $param->branch);
        }

        if(isset($param->department) && !empty($param->department)){
            $result["query"] = $result["query"]->whereIn("ticket.Department", $param->department);
        }

        if(isset($param->category) && !empty($param->category)){
            $result["query"] = $result["query"]->whereIn("ticket.Category", $param->category);
        }

        if(isset($param->subject) && !empty($param->subject)){
            $result["query"] = $result["query"]->whereIn("ticket.Subject", $param->subject);
        }

        if(isset($param->level) && !empty($param->level)){
            $result["query"] = $result["query"]->whereIn("ticket.PriorityLevel", $param->level);
        }

        if(isset($param->dateFrom) && !empty($param->dateFrom)){
            $result["query"] = $result["query"]->whereDate("ticket.created_at",">=",$param->dateFrom);
        }

        if(isset($param->dateTo) && !empty($param->dateTo)){
            $result["query"] = $result["query"]->whereDate("ticket.created_at","<=",$param->dateTo);
        }

        if(isset($param->status) && !empty($param->status)){
            $result["query"] = $result["query"]->whereIn("ticket.Status",$param->status);
        }
        
        $result["columns"] = array(
            array( 'db' => 'Id', 'dt' => 0,'orderable' => false, 'sortnum'=>true),
            array( 'db' => 'TicketNo', 'dt' => 1,'formatter' => function($d, $row) use($category){
                $ticketNo = $d <= 999 ? sprintf('%03d', $d) : $d;
                return $category[$row["Category"]]["code"]."-". $ticketNo;
            }),
            array( 'db' => 'Branch', 'dt' => 2,'formatter' => function($d) use($branch){
                return $branch[$d]["name"];
            }),
            array( 'db' => 'Department', 'dt' => 3,'formatter' => function($d) use($department){
                return $department[$d]["name"];
            }),
            array( 'db' => 'Category', 'dt' => 4,'formatter' => function($d) use($category){
                return $category[$d]["name"];
            }),
            array( 'db' => 'Status', 'dt' => 5,'formatter' => function($d) use($status){
                switch($d){
                    case 1:
                        $statusColor = "text-secondary border border-secondary";
                    break;
            
                    case 2:
                        $statusColor = "text-info border border-info";
                    break;
            
                    case 4:
                        $statusColor = "text-dark border border-dark";
                    break;
            
                    default:
                        $statusColor = "text-primary border border-primary";
                    break;
                }
                
                return "<p class='rounded-lg text-center font-weight-bold p-1 m-0 disabled ".$statusColor."'>".$status[$d]."</p>";
            }),
            array( 'db' => 'Reporter', 'dt' => 6,'formatter' => function($d) use($user){
                return $user[$d]["firstname"] . " " . $user[$d]["lastname"];
            }),
            array( 'db' => 'Id', 'dt' => 7,'formatter' => function($d){
                return "<div class='btn-group'>
                <button type='button' class='btn btn-sm btn-light' data-toggle='dropdown'><i class='fas fa-ellipsis-h'></i>
                </button>
                <div class='dropdown-menu dropdown-menu dropdown-menu-right ticketMenuBtn' data-ticketid='".$d."'>
                  <a class='dropdown-item viewTicket' href=".route("admin.viewticket")."><i class='fas fa-eye'></i> View</a>
                  <a class='dropdown-item editTicket'><i class='fas fa-edit'></i> Edit</a>
                  <a class='dropdown-item assigneeTicket'><i class='fas fa-user'></i> Assign Ticket</a>
                  <a class='dropdown-item assigneeTicket'><i class='fas fa-history'></i> Ticket History</a>
                  <a class='dropdown-item deleteTicket'><i class='fas fa-trash'></i> Delete</a>
                </div>
              </div>";
            }),
        );
        return $result;
    }
}
