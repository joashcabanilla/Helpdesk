<?php

namespace App\Classes;

class HelperClass
{
    function UserStatus(){
        return [
            "" => "All Status",
            "active" => "Active",
            "locked" => "Locked",
            "deactivated" => "Deactivated",
        ];
    }

    function ticketStatus(){
        return [
            "" => "All Status",
            "1" => "To Do",
            "2" => "In Progress",
            "3" => "Done",
            "4" => "Backlog"
        ];
    }

    function ticketLevel(){
        return [
            "" => "All Level",
            "1" => "Low",
            "2" => "Medium",
            "3" => "High",
            "4" => "Urgent"
        ];
    }
}
