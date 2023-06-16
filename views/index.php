<!-- authentecation -->
<?php
ob_start();
session_start();
if (!isset($_SESSION["phone_number"])) {
    header("location: ./Auth/login.php");
}
// echo $_SESSION["phone_number"] ;
require_once "../controllers/Contact_controller.php";
$contact_controller = new Contact_controller;
$contacts = $contact_controller->get_contacts();

?>

<!-- interface of project -->

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/index.css" />
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">

                    <div id="plist" class="people-list">
                        <div class="buttons" style="display:inline-blick">
                            <!-- create logout button -->
                            <form method="POST">
                                <input class="btn btn-secondary mb-3 w-20" type="submit" name="logout" value="Logout" />
                            </form>
                            <?php
                            // logout handling
                            if (isset($_POST["logout"])) {
                                require_once "../models/User.php";
                                $user = new User;
                                $user->logout();
                            }
                            ?>
                            <form method="POST">
                                <input class="btn btn-danger mb-3 w-20" type="submit" name="Delete_Acc" value="Delete My Account" />
                            </form>
                            <?php
                            // logout handling
                            if (isset($_POST["Delete_Acc"])) {

                                require_once "../models/User.php";
                                $user = new User;
                                $user->delete_account();
                                $user->logout();
                            }
                            ?>
                            <a href="manage_account.php"> <button type="button" class="btn btn-secondary mb-3 w-20" styles="display:inline-block"><i class="fa-regular fa-user"></i> Manage Account
                                </button>
                            </a>
                            <a href="add_new_contact.php"> <button type="button" class="btn btn-secondary mb-3 w-20" styles="display:inline-block"><i class="fa fa-address-book" aria-hidden="true"></i>
                                    Add new contact</button>
                            </a>
                        </div>

                        <!-- search  -->

                        <div class="input-group-prepend">
                            <form method="post">
                                <input type="text" name="search" class="form-control w-50 d-inline" placeholder="Search..." />
                                <span class="input-group-text w-50 d-inline ">
                                    <i class="fa fa-search"></i><input class="border-0" type="submit" value="->" />
                                </span>
                            </form>
                        </div>
                        <?php
                        // search handling
                        if (isset($_POST["search"])) {
                            require_once "../models/User.php";
                            require_once "../controllers/DB_controller.php";
                            $user = new User;
                            $db = new DB_controller;
                            $result =  $user->search(new mysqli($db->db_host, $db->db_user, $db->db_password, $db->db_name), $_POST["search"]);
                            if ($result) {
                                // echo $result["id"] ;
                        ?>
                                <ul class="list-unstyled chat-list mt-2 mb-0">
                                    <li class="clearfix">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                        <div class="about">
                                            <div class="about"><?php echo $result["contact_name"]  ?></div>
                                            <div class="about" id="second">
                                                <?php echo $result["phone_number"] ?>
                                                <a href="index.php"> <button type="button" class="btn btn-primary mb-3 w-20" styles="display:inline-block"> -< Return Back to start Chat with <?php echo $result["contact_name"] ?> </button>
                                                </a>
                                            </div>

                                    </li>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <div class="alert alert-dark mt-2" role="alert">
                                    <?php
                                    echo "Contact not found !";
                                    ?>
                                </div>
                        <?php
                                unset($_POST["search"]);
                            }
                        }

                        ?>

                        <ul class="list-unstyled chat-list mt-2 mb-0">
                            <?php
                            if (!empty($contacts) && !isset($_POST["search"])) {
                                foreach ($contacts as $key =>  $contact) {
                            ?>
                                    <li class="clearfix">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                        <div class="about">
                                            <div class="about" value=""> <?php echo $contact["contact_name"] ?></div>
                                            <div class="about" id="second" value=" ">
                                                <?php echo  $contact["phone_number"] ?>
                                            </div>
                                            <div value="">
                                                <form method="POST" action="index.php">
                                                    <input type="hidden" name="delete_id_button_of<?php echo $key ?>" />
                                                    <!-- create delete button -->
                                                    <input class="btn btn-danger d-inline-block" type="submit" value="Delete" />
                                                </form>
                                                <form method="POST"  class="m-3">
                                                    <input type="hidden" name="ubdate_id_button_of<?php echo $key ?>" />
                                                    <!-- create delete button -->
                                                    <input class="btn btn-primary d-inline-block" type="submit" value="Ubdate" />
                                                </form>
                                                <form method="POST" action="index.php" class="m-3">
                                                    <input type="hidden" name="chat_id_button_of<?php echo $key ?>" />
                                                    <!-- create chat button -->
                                                    <input class="btn btn-primary d-inline-block" type="submit" value="Chat" />
                                                </form>
                                                <!-- to delete specefied contact -->
                                                <?php
                                                if (isset($_POST["delete_id_button_of" . $key])) {
                                                    if (!empty($contacts)) {
                                                        $contact_controller->delete_contact($contacts[$key]["id"]);
                                                        header("Refresh:0");
                                                    }
                                                }
                                                ?>

                                                <!-- to ubdate specefied contact -->
                                                <?php
                                                if (isset($_POST["ubdate_id_button_of" . $key])) {
                                                    if (!empty($contacts)) {
                                                        $_SESSION["contact_phone_number_id"] = $contacts[$key]["id"];
                                                        header("location:../views/ubdate_contact.php");
                                                    }
                                                }
                                                ?>


                                                <!-- to chat with specefied contact -->
                                                <?php
                                                if (isset($_POST["chat_id_button_of" . $key])) {
                                                    if (!empty($contacts)) {
                                                        $_SESSION["contact_name"] =  $contacts[$key]["contact_name"];
                                                        $_SESSION["contact_phone_number"] =  $contacts[$key]["phone_number"];
                                                        header("location:./chat.php");
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </li>
                            <?php
                                }
                            }


                            ?>




                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>



    </div>

</body>

</html>

<?php

?>