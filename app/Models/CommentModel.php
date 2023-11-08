<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use DateTime;

class CommentModel extends Model
{
    use HasFactory;
    protected $table = 'comment';
    protected $primaryKey = 'Id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'TicketId',
        'User',
        'Comment'
    ];

    protected $userModel;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->userModel = new User();
    }

    function GetTicketComment($ticketId){
        $result = array();
        $user = $this->userModel->getAllUser();
        $comments = $this->where("TicketId",$ticketId)->orderBy("created_at")->get();
        $dateToday = date('Y-m-d H:i:s');
        $dateToday = new DateTime($dateToday);

        foreach($comments as $comment){
            if(isset($user[$comment->User])){
                $dateComment = date('Y-m-d H:i:s', strtotime($comment->created_at));
                $dateComment = new DateTime($dateComment);
                $dateDiff = $dateComment->diff($dateToday);
                $date = "";
                $date = $dateDiff->i != 0 ? ($dateDiff->i > 1 ? $dateDiff->i . "mins" :  $dateDiff->h . " minute ago") : $date;
                $date = $dateDiff->h != 0 ? ($dateDiff->h > 1 ? $dateDiff->h . "hrs" :  $dateDiff->h . " hour ago") : $date;
                $date = $dateDiff->d != 0 ? ($dateDiff->d > 1 ? $dateDiff->d . "d" :  $dateDiff->d . " day ago") : $date;
                $date = $dateDiff->m != 0 ? ($dateDiff->m > 1 ? $dateDiff->m . "mos" :  $dateDiff->m . " month ago") : $date;
                $date = $dateDiff->y != 0 ? ($dateDiff->y > 1 ? $dateDiff->y . "yrs" :  $dateDiff->y . " year ago") : $date;

                $result[] = [
                    "id" => $comment->Id,
                    "comment" => $comment->Comment,
                    "user" => $user[$comment->User],
                    "date" => $date
                ];
            }
        }   

        return $result;
    }

    function CreateComment($data){
        if(!empty($data->commentInput)){
            return $this->create([
                "TicketId" => $data->ticketId,
                "User" => Auth::user()->Id,
                "Comment" => $data->commentInput
            ]);
        }
        return false;
    }
}