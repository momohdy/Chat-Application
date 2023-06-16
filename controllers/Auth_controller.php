<?php

require_once '../../models/User.php';
require_once 'DB_controller.php';

class Auth_controller
{
    protected $db;

    public function login(User $user)
    {
        $this->db = new DB_controller;
        if ($this->db->open_connection()) {
            // create Query
            $query = "select * from users where phone_number = '$user->phone_number' and password = '$user->password' ";
            // use select func
            $result = $this->db->select($query);
            if ($result !== false) // check if the query is true and return obj  
            {
                // check if the result was true or not 
                if (!count($result) == 0) {
                    session_start();
                    $_SESSION["id"] = $result[0]["id"];
                    $_SESSION["phone_number"] = $result[0]["phone_number"];
                    $_SESSION["password"] = $result[0]["password"];
                    return true;
                } else {
                    $_SESSION["err_msg"] = "You have entered a wrong phone_number and password";
                    return false;
                }
            } else {
                echo "Your Query is not true";
                return false;
            }
        } else {
            echo "Error in Connection";
            return false;
        }
    }

    public function register(User $user)
    {
        $this->db = new DB_controller;
        if ($this->db->open_connection()) {

            $query = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone_number`, `password`) VALUES (NULL , '$user->first_name', '$user->last_name', '$user->phone_number', '$user->password')";
            if ($this->db->insert($query)) {
                // session_start();
                // $_SESSION["name"] = $user->first_name;
                // $_SESSION["phone_number"] = $user->phone_number;
                // $_SESSION["password"] = $user->password;
                // $this->db->close_connection();
                
                // $result = mysqli_fetch_assoc(mysqli_query(new mysqli("localhost", "root", "", "chat_application"), "SELECT id FROM users WHERE phone_number = '$user->phone_number' "));
                // $_SESSION["id"] = $result[0]["id"];
                return true;
            }
        } else {
            $_SESSION["errMsg"] = "Somthing Went Wrong Please try again.....";
            return false;
        }
    }
}
