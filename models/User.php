<?php
class User
{
    public $id;
    public $first_name;
    public $last_name;
    public $phone_number;
    public $password;


    public function logout()
    {
        session_destroy();
        header('location: ../views/Auth/login.php');
        exit();
    }

    public function ubdate_user($user)
    {
        require_once "../controllers/User_controller.php" ;
        $user_controller = new User_controller ;
        if($user_controller->ubdate($user) )
        {
            echo "donnnnne" ;
            return true ;
        }
    }

    public function delete_account()
    {
        $id = $_SESSION["id"];
        if( mysqli_query(new mysqli("localhost", "root", "", "chat_application"), "DELETE FROM `users` WHERE id = $id "))
        {
            return true ;
        }
    }

    public function search($conn, $contactName) {
        $id = $_SESSION["id"] ; 
        $sql = "SELECT * FROM contacts WHERE contact_name='$contactName' And user_id = $id ";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // return the first matching contact
            $row = mysqli_fetch_assoc($result);
            return $row ;
        } else {
            return null;
        }
    }
    


}
