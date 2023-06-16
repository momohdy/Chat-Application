<?php

require_once 'DB_controller.php';

class User_controller
{
    protected $db;



    public function ubdate($user)
    {
        session_start() ;
        $id = $_SESSION["id"] ;
        $this->db = new DB_controller ;
        if($this->db->open_connection())
        {
            $query = "UPDATE `users` SET `first_name` = '$user->first_name', `last_name` = '$user->last_name', `phone_number` = '$user->phone_number', `password` = '$user->password' WHERE `users`.`id` = $id " ;
            if($this->db->ubdate($query))
            {
                return true ;
            }
            else
            {
                echo "Error in ubdate user Query";
            }
        }
        else 
        {
            echo "Error in Connection ";
            return false ;
        }
    }
}

?>