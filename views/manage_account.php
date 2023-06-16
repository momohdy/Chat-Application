<?php

$err_msg = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/add_new_contact.css">
</head>

<body>

    <div class="contact1">



        <div class="container-contact1">



            <form class="contact1-form validate-form" method="POST" action="manage_account.php">
                <span class="contact1-form-title">
                    MANAGE ACCOUNT
                </span>


                <!-- // alert for check empty fields ///// -->
                <?php
                if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone_number']) && isset($_POST['password'])) {
                    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['phone_number']) || empty($_POST['password'])) {
                ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            $err_msg = "Please fill all Fields";
                            echo $err_msg;
                            ?>
                        </div>
                <?php
                    } else {
                        require_once "../models/User.php" ;
                        $user = new User;
                        $user->first_name = $_POST["first_name"];
                        $user->last_name = $_POST["last_name"];
                        $user->phone_number = $_POST["phone_number"];
                        $_SESSION["phone_number"] = $_POST["phone_number"];
                        $user->password = $_POST["password"];
                        require_once "../controllers/DB_controller.php";
                        $db = new DB_controller ;

                        if ($user->ubdate_user($user)) {
                            header("location: ../views/index.php");
                        } else {
                            echo "contact did not added";
                        }
                    }
                }
                ?>




                <div class="wrap-input1 validate-input">


                    <input class="input1" type="text" name="first_name" placeholder="First Name">
                </div>

                <div class="wrap-input1 validate-input">


                    <input class="input1" type="text" name="last_name" placeholder="Last Name">
                </div>

                <div class="wrap-input1 validate-input">
                    <input class="input1" type="text" name="phone_number" placeholder="Phone number , MUST be 01(<=9 digits)">
                    <!-- <span class="shadow-input1"></span> -->
                </div>

                <div class="wrap-input1 validate-input">
                    <input class="input1" type="password" name="password" placeholder="Password">
                    <!-- <span class="shadow-input1"></span> -->
                </div>



                <div class="container-contact1-form-btn ">
                    <input type="submit" value="Save Acoount" class="contact1-form-btn">
                    <!-- <i class="fa fa-long-arrow-right" aria-hidden="true"></i> -->
                </div>



            </form>
        </div>
    </div>





</body>

</html>