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
if (isset($_POST['contact_name']) && isset($_POST['phone_number'])) {
    if (!empty($_POST['contact_name']) && !empty($_POST['phone_number'])) {
        $contact = new Contact;
        $contact->contact_name = $_POST["contact_name"];
        $contact->phone_number = $_POST["phone_number"];
        if ($contact_cotroller->add_contact($contact)) {
            header("location: ../views/index.php");
        } else {
            echo "contact did not added";
        }
    } else {
        $err_msg = "Please fill the fields";
    }
}

function delete($contact)
{
    ///
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add New Contact</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../styles/add_new_contact.css">
</head>

<body>

    <div class="contact1">



        <div class="container-contact1">



            <form class="contact1-form validate-form" method="POST" action="add_new_contact.php">
                <span class="contact1-form-title">
                    NEW CONTACT
                </span>
                
                
                <!-- // alert for check empty fields ///// -->
                <?php
                if (isset($_POST['contact_name']) && isset($_POST['phone_number'])) {
                    if (empty($_POST['contact_name']) || empty($_POST['phone_number'])) {
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


                    <input class="input1" type="text" name="contact_name" placeholder="Name">
                </div>

                <div class="wrap-input1 validate-input">
                    <input class="input1" type="text" name="phone_number" placeholder="Phone number , MUST be 01(<=9 digits)">
                    <!-- <span class="shadow-input1"></span> -->
                </div>



                <div class="container-contact1-form-btn ">
                    <input type="submit" value="Save Contact" class="contact1-form-btn">
                    <!-- <i class="fa fa-long-arrow-right" aria-hidden="true"></i> -->
                </div>



            </form>
        </div>
    </div>





</body>

</html>