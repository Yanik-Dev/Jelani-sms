<?php 
$title = "Login";
include 'header.php'; 

include '../config/Setup.php';
include '../models/User.php';
include '../services/AuthService.php';

if (isset($_POST['loginBtn'])) {
  var_dump($_POST['password']);
  $user=new User();
  var_dump($_POST['password']);
  $user->setUsername($_POST['username']);
  $user->setPassword($_POST['password']);
  AuthService::login($user);
} 
?>
<div class="app app-default">
<div class="app-container app-login">
  <div class="flex-center">
    <div class="app-header"></div>
    <div class="app-body">
      <div class="loader-container text-center">
          <div class="icon">
              <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
              </div>
            </div>
          <div class="title">Logging in...</div>
      </div>
      <div class="app-block">
      <div class="app-form">
        <div class="form-header">
          <div class="app-brand">
            <span class="highlight">
              <center> Jelani </center>
            </span>
            <br>School Management System
            </div>
        </div>
        <form action="./login.php" method="post">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1">
                <i class="fa fa-user" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" name="username" id="userName">
            </div>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon2">
                <i class="fa fa-unlock-alt" aria-hidden="true"></i></span>
              <input type="password" class="form-control" placeholder="Password" aria-describedby="basic-addon2" name="password" id="password">
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-success btn-submit" value="Login" name="loginBtn" id="">
            </div>
        </form>
     </div>
    </div>
 <?php include 'footer.php'; ?>