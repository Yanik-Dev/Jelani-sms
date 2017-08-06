<?=
session_start();
require './../services/SessionService.php';
require './../services/AuthService.php';

//logout user
if(isset($_GET['logout'])){
    AuthService::logout();
    header('location: ./login.php');
    exit;
}

//check if user is logged in
$session = SessionService::getSessionObj('user');

if(!isset($session)){
  header('location: ./login.php');
  exit;
}

?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'nav.php'; ?>
    
<div class="row">