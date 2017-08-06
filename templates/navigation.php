<?=
session_start();

require './../services/SessionService.php';

$session = SessionService::getSessionObj('user');

if(!isset($session)){
  header('location: ./login.php');
}

?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'nav.php'; ?>
    
<div class="row">