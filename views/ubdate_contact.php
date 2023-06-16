<!-- authentecation -->
<?php
session_start();
if (!isset($_SESSION["phone_number"])) {
    header("location: ./Auth/login.php");
}


require_once "../controllers/Contact_controller.php";
require_once "../models/Contact.php";
$err_msg = "";
$contact_cotroller = new Contact_controller;
if (isset($_POST['phone_number'])) {
    if (!empty($_POST['phone_number'])) {
        if ($contact_cotroller->ubdate_contact($_POST['phone_number'])) {
            header("location: ../views/index.php");
        } else {
            echo "contact did not ubdated";
        }
    } else {
        $err_msg = "Please fill the new Number";
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ubdate Contact</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/add_new_contact.css">
</head>

<body>

    <div class="contact1">



        <div class="container-contact1">



            <form class="contact1-form validate-form" method="POST" action="ubdate_contact.php">
                <span class="contact1-form-title">
                UBDATE CONTACT
                </span>
                
                
                <!-- // alert for check empty fields ///// -->
                <?php
                if (isset($_POST['phone_number'])) {
                    if (empty($_POST['phone_number'])) {
                ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            echo $err_msg;
                            ?>
                        </div>
                <?php
                    }
                }
                ?>

                <div class="wrap-input1 validate-input">
                    <input class="input1" type="text" name="phone_number" placeholder="Phone number , MUST be 01(<=9 digits)">
                </div>

                <div class="container-contact1-form-btn ">
                    <input type="submit" value="Ubdate Contact" class="contact1-form-btn">
                </div>

            </form>
        </div>
    </div>

</body>

</html>