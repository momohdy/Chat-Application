<?php
require_once '../controllers/DB_controller.php';

if (isset($_POST["submit"])) {
    session_start();
    define('SITE_ROOT', realpath(dirname(__FILE__)));

    if ($_FILES["image"]["error"] === 4) {
        echo "<script> alert('image does not exist'); </script>";
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpname = $_FILES["image"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];

        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script> alert('invalid image extension'); </script>";
        } else if ($fileSize > 1000000) {
            echo "<script> alert('image size is too large'); </script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;
            $sender = $_SESSION["phone_number"];
            $receiver = $_SESSION["contact_phone_number"];
            move_uploaded_file($tmpname, $newImageName);
            $qry = "INSERT INTO `messages`(`id`, `sender`, `receiver`, `timestamp`, `content`) VALUES ('','$sender','$receiver', CURRENT_TIMESTAMP ,'$newImageName')";
            mysqli_query(new mysqli("localhost", "root", "", "chat_application"), $qry);
            echo "<script> document.location.href = 'chat.php'; </script>";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Upload image file</title>
    <meta charset="UTF-8">
</head>

<body>
    <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data" style="justify-content:center; display: flex; margin: 100px 50px;">
        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" value="" style="margin-top: 9px;"> <br><br>
        <button type="submit" name="submit">submit</button>
    </form>
</body>

</html>