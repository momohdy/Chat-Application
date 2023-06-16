<!-- authentecation -->
<?php
ob_start();
session_start();
if (!isset($_SESSION["phone_number"])) {
    header("location: ./Auth/login.php");
}

require_once "../controllers/Chat_controller.php";
$message_controller = new Chat_controller;
$messages = $message_controller->get_messages();

// echo $_SESSION["phone_number"] . " " . $_SESSION["contact_phone_number"];

?>

<!-- interface of chat page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chat Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />


    <link href="../styles/chat.css" rel="stylesheet">
</head>

<body>

    <div class="chat">
        <div class="chat-header clearfix">
            <div class="row">

                <div class="col-lg-6">
                    <a href="###">
                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                    </a>
                    <div class="chat-about">
                        <h6 class="m-b-0"><?php if ($_SESSION["contact_name"] != "") echo $_SESSION["contact_name"];
                                            ?></h6>
                        <small><?php if ($_SESSION["contact_phone_number"] != "") echo $_SESSION["contact_phone_number"];
                                ?></small>
                    </div>
                </div>

                <!-- icons  -->
                <div class="col-lg-6 hidden-sm text-right">
                    <a href="./upload_media.php" class="btn btn-outline-secondary "><i class="fa fa-camera"></i></a>
                    <a href="./upload_audio.php" class="btn btn-outline-secondary"><i class="fa-solid fa-microphone"></i></a>
                    <a href="./location.php" class="btn btn-outline-secondary"><i class="fa-solid fa-map"></i></a>
                    <a href="../models/Call.php" class="btn btn-outline-secondary"><i class="fa-solid fa-phone"></i></a>
                    <!-- <a href="######" class="btn btn-outline-secondary"><i class="fa-solid fa-video"></i></a> -->
                </div>
            </div>
        </div>

        <!-- display messages -->
        <?php
        foreach ($messages as $message) {
        ?>
            <div class="chat-history">
                <ul class="m-b-0">
                    <?php if ($message["sender"] == $_SESSION["phone_number"] && $message["receiver"] == $_SESSION["contact_phone_number"]) {
                    ?>
                        <li class="clearfix">
                            <div class="message-data text-right">
                                <span class="message-data-time"><?php echo $message["timestamp"]; ?></span>
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                            </div>

                            <!-- in case of img -->
                            <div class="message other-message float-right"> <?php $extension = pathinfo($message["content"], PATHINFO_EXTENSION);
                                                                            if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png'))) {
                                                                                // The content is an image
                                                                                ?> <img src="<?php echo $message["content"] ?>" width="200px" height="50px" /><?php
                                                                            } else if (in_array(strtolower($extension), array('m4a', 'mp3','aac'))){
                                                                                ?>  <audio controls> 
                                                                                        <source src="<?php echo $message["content"]; ?>" type="audio/mpeg"> 
                                                                                    </audio> <?php
                                                                            } else  {
                                                                                // The content is simple text
                                                                                echo $message["content"] ;
                                                                            } ?> <?php } ?> </div>

                        </li>
                        <?php if ($message["sender"] == $_SESSION["contact_phone_number"] && $message["receiver"] == $_SESSION["phone_number"]) { ?>
                            <li class="clearfix">
                                <div class="message-data m-3">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                    <span class="message-data-time"><?php echo $message["timestamp"]; ?></span>
                                </div>
                                <div class="message my-message m-3 "><?php $extension = pathinfo($message["content"], PATHINFO_EXTENSION);
                                                                            if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png'))) {
                                                                                // The content is an image
                                                                                ?> <img src="<?php echo $message["content"] ?>" width="200px" height="50px" /><?php
                                                                            } else if (in_array(strtolower($extension), array('m4a', 'mp3','aac'))){
                                                                                ?>  <audio controls> 
                                                                                        <source src="<?php echo $message["content"]; ?>" type="audio/mpeg"> 
                                                                                    </audio> <?php
                                                                            } else {
                                                                                // The content is simple text
                                                                                echo $message["content"] ;
                                                                    } } ?></div>
                            </li>
                </ul>
            </div>
        <?php
        }
        ?>

        <!-- input text messages -->
        <div class="chat-message clearfix">
            <form method="post" action="chat.php">
                <input type="text" class="form-control w-70 " name="message" placeholder="Enter text here...">
                <input type="submit" class="form-control w-20" value="Send">
                <?php
                if (isset($_POST["message"])) {
                    if (!empty($_POST["message"])) {
                        $message_content = $_POST["message"];
                        require_once '../models/Message.php';
                        $sm = new Message();
                        $rebeet = mysqli_fetch_assoc(mysqli_query(new mysqli("localhost", "root", "", "chat_application"), "SELECT content FROM messages WHERE content = '$message_content'  "));
                        if (!$message_content == $rebeet) {
                            $sm->sendMessage($_SESSION["contact_phone_number"], $message_content);
                            header("Refresh:0");
                        }
                    }
                }
                ?>
            </form>

        </div>


        <a href="index.php"> <button type="button" class="btn btn-secondary m-3 w-20" styles="display:inline-block"><- CONTACTS LIST</button>
        </a>

        <form method="POST">
            <input class="btn btn-danger mb-3 w-20" type="submit" name="delete_conversation" value="DELETE CONVERSATION" />
        </form>
        <?php
        // delete conversation handling
        if (isset($_POST["delete_conversation"])) {
            $sen = $_SESSION["phone_number"];
            $rec = $_SESSION["contact_phone_number"];
            $sql = "DELETE FROM `messages` WHERE `messages`.`sender` = $sen AND `messages`.`receiver` = $rec ";
            mysqli_query(new mysqli("localhost", "root", "", "chat_application"), $sql);

            $sql = "DELETE FROM `messages` WHERE `messages`.`sender` = $rec AND `messages`.`receiver` = $sen ";
            mysqli_query(new mysqli("localhost", "root", "", "chat_application"), $sql);
            header("location:./index.php");
        }
        ?>

    </div>




    </div>

</body>

</html>

<?php

?>