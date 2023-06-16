<?php
require_once '../../models/User.php';
require_once '../../controllers/Auth_controller.php';

if (!isset($_SESSION['user'])) {
  session_start();
}

$errMsg = "";

if (isset($_POST['phone_number']) && isset($_POST['password']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['confirm_password'])) {
  if (!empty($_POST['phone_number']) && !empty($_POST['password']  && !empty($_POST['first_name']))) {
    if ($_POST['password'] == $_POST['confirm_password']) {
      $user = new user;
      $auth = new Auth_Controller;
      $user->phone_number = $_POST['phone_number'];
      $user->password = $_POST['password'];
      $user->first_name = $_POST['first_name'];
      $user->last_name = $_POST['last_name'];
      if (!$auth->register($user)) {
        $err_msg = $_SESSION["err_msg"];
      } else {
        $result = mysqli_fetch_assoc(mysqli_query(new mysqli("localhost", "root", "", "chat_application"), "SELECT id FROM users WHERE phone_number = '$user->phone_number' "));
        $_SESSION["id"] = $result["id"];
        $_SESSION["phone_number"] = $_POST['phone_number'];
        header("location: ../index.php");
      }
    } else {
      $errMsg = "Password did not match with Confirm";
    }
  } else {
    $errMsg = "Please fill in all fields";
  }
}

?>

<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com-->
<html lang="en" dir="ltr">

<head>
  <title>Register</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!--<title> Registration or Sign Up form in HTML CSS | CodingLab </title>-->
  <link rel="stylesheet" href="../../styles/Auth_css/register.css">
</head>

<body>
  <div class="wrapper">
    <h2>Registration</h2>
    <?php if ($errMsg != "") {
      ?>
      <div class="alert alert-danger" role="alert">
          <?php
          echo $errMsg;
          ?>

        </div>
      <?php
      
    } ?>
    <form method="post">
      <div class="input-box">
        <input type="text" name="first_name" placeholder="Enter your First name"  >
      </div>
      <div class="input-box">
        <input type="text" name="last_name" placeholder="Enter your Last name"  >
      </div>
      <div class="input-box">
        <input type="text" name="phone_number" placeholder="Phone number , MUST be 01(<=9 digits)"  >
      </div>  
      <div class="input-box">
        <input type="password" name="password" placeholder="Create password"  >
      </div>
      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="Confirm password"  >
      </div>
      <!-- <div class="policy">
        <input type="checkbox">
        <h3>I accept all terms & condition</h3>
      </div> -->
      <div class="input-box button">
        <input type="Submit" value="Register Now">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="login.php">Login now</a></h3>
      </div>
    </form>
  </div>
</body>