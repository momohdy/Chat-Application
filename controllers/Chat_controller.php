<?php

require_once 'DB_controller.php';


class Chat_controller
{
    protected $db;

    public function get_messages()
    {
        $this->db = new DB_controller ;
        if($this->db->open_connection())
        {
            $query = "select * from messages" ;
            return $this->db->select($query) ;
        }
        else 
        {
            echo "Error in Connection ";
            return false ;
        }

    }



    
}
