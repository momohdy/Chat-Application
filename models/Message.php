<?php

class Message
{
    public $id;
    public $sender;
    public $receiver;
    public $timestamp;
    public $content;

    public function sendMessage($receiver, $content)
    {
        $sender = $_SESSION["phone_number"] ;
        $receiver = filter_var($receiver, FILTER_SANITIZE_STRING);
        $content = filter_var($content, FILTER_SANITIZE_STRING);
        require_once '../controllers/DB_controller.php';
        $db = new DB_controller;
        if ($db->open_connection()) {
            $sql = "INSERT INTO `messages`(`id`, `sender`, `receiver`, `timestamp`, `content`) VALUES ('', $sender ,'$receiver', CURRENT_TIMESTAMP ,'$content')";
            if (mysqli_query(new mysqli("localhost", "root", "", "chat_application"), $sql)) {
                echo "Message sent successfully.";
            } else {
                echo "Message sending failed: " . mysqli_error($conn);
            }
        }
    }
}


