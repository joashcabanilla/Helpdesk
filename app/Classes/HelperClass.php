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
}
