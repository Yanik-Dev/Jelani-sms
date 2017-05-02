<?php
include '../models/User.php';
include '../services/AuthService.php';

if (!isset($_POST['loginBtn'])) {
    header("Location: ../templates/login.php");
} 

if (!isset($_POST['password'])) {
    header("Location: ../templates/login.php");
} 

if (!isset($_POST['password'])) {
    header("Location: ../templates/login.php");
} 

$user=new User();
var_dump($_POST['password']);
$user->setUsername($_POST['username']);
$user->setPassword($_POST['password']);
AuthService::login($user);
?>