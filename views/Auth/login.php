<?php
require_once "../../models/User.php";
require_once '../../controllers/Auth_controller.php';
// variable checker for displaying or un display alert
$err_msg = "";

if (isset($_POST['phone_number']) && isset($_POST['password'])) {
  if (!empty($_POST['phone_number']) && !empty($_POST['password'])) {
    $user = new User;
    $auth = new Auth_controller;
    $user->phone_number = $_POST['phone_number'];
    $user->password = $_POST['password'];

    // call login func from Auth_controller.php to check the $user obj
    if (!$auth->login($user)) {
      
      $err_msg = $_SESSION["err_msg"];
    } else {

      header("location: ../index.php");
    }
  } else {
    $err_msg = "Please fill the fields";
  }
}


?>



<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title>Login Form | CodingLab</title> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="/styles/authorisationCss/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
  <link rel="stylesheet" href="../../styles/Auth_css/login.css">
</head>

<body>
  <div class="container">
    <div class="wrapper">
      <div class="title"><span>Login Form</span></div>

      <?php
      if ($err_msg != "") {
      ?>

        <!-- // alert for login error ///// -->
        <div class="alert alert-danger" role="alert">
          <?php
          echo $err_msg;
          ?>

        </div>

      <?php
      }
      ?>

      <form action="login.php" method="POST">
        <div class="row">
          <i class="fas fa-user"></i>
          <input type="text" placeholder="phone_number" name="phone_number">
        </div>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input type="password" placeholder="Password" name="password">
        </div>

        <div class="row button">
          <input type="submit" value="Login">
        </div>
        <div class="signup-link">Not a member? <a href="register.php">Signup now</a></div>
      </form>

    </div>
  </div>

</body>

</html>