<?php
session_start();
require '../models/User.php';
require '../services/AuthService.php';
require '../common/Security.php';
require '../services/SessionService.php';

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
$user->setUsername($_POST['username']);

$user = AuthService::login($user);

if($user->getUsername() != null){
    $password = Security::getHash($_POST['password'], $user->getSalt());
    if(strcmp($password, $user->getPassword()) == 0){
        $sessionUser = new User();
        $sessionUser->setId($user->getId());
        $sessionUser->setFirstName($user->getFirstName());
        $sessionUser->setUsername($user->getUsername());
        $sessionUser->setLastName($user->getLastName());
        $sessionUser->setGender($user->getGender());
        SessionService::setSessionObj("user", $sessionUser);
        header("Location: ../templates/home.php");
        exit;
    }
}
header("Location: ../templates/login.php?error=1");
?>