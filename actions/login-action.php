<?php
require '../models/User.php';
require '../services/AuthService.php';
require '../common/Security.php';

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

$user = AuthService::login($user);

if($user->getUsername() != null){
    $password = Security::getHash($_POST['password'], $user->getSalt());
    if(strcmp($password, $user->getPassword())){
        
    }
}
header("Location: ../templates/login.php?error=1");
?>