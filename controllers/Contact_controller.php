<?php

require_once 'DB_controller.php';

class Contact_controller
{
    protected $db;

    public function get_contacts()
    {
        $this->db = new DB_controller ;
        if($this->db->open_connection())
        {
            $id = $_SESSION["id"] ;
            $query = "select * from contacts where user_id = $id " ;
            return $result = $this->db->select($query) ;

            // if($result !== false )
            // {
            //     if(count($result) != 0)
            //     {

            //     }
            //     else 
            //     {

            //     }
            // }
            // else
            // {
            //     echo "Your Query is not true ";
            //     return false ;
            // }
        }
        else 
        {
            echo "Error in Connection ";
            return false ;
        }

    }

    public function add_contact($contact)
    {
        $this->db = new DB_controller ;
        if($this->db->open_connection())
        {
            $id = $_SESSION["id"] ;
            $query = "insert into `contacts` (`phone_number`, `id`, `contact_name` , user_id ) VALUES ('$contact->phone_number',null,'$contact->contact_name' , $id )" ;
            if($this->db->insert($query))
            {
                return true ;
            }
            else
            {
                echo "Error in insert Query";
            }
        }
        else 
        {
            echo "Error in Connection ";
            return false ;
        }
    }
    public function ubdate_contact($new_number)
    {
        $this->db = new DB_controller ;
        if($this->db->open_connection())
        {
            $id = $_SESSION["contact_phone_number_id"] ;
            $query = "UPDATE `contacts` SET `phone_number`='$new_number' WHERE id = '$id' " ;
            $_SESSION["contact_phone_number"] = $new_number ;
            if($this->db->ubdate($query))
            {
                return true ;
            }
            else
            {
                echo "Error in ubdate Query";
            }
        }
        else 
        {
            echo "Error in Connection ";
            return false ;
        }
    }

    public function delete_contact($contact_id)
    {
        $this->db = new DB_controller ;
        if($this->db->open_connection())
        {
            $query = "delete from `contacts` WHERE `contacts`.`id` = '$contact_id'" ;
            if($this->db->drop($query))
            {
                return true ;
            }
            else
            {
                echo "Error in delete Query";
            }
        }
        else 
        {
            echo "Error in Connection ";
            return false ;
        }
    }

    // public function start_chat($will_chat)
    // {
    //     echo $will_chat  ;
    // }

    
}
