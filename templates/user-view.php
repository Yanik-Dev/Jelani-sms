<?php 
$title="Users";
require './navigation.php';
require_once dirname(__FILE__).'/../services/UserService.php';
require_once dirname(__FILE__).'/../services/SessionService.php';
require_once dirname(__FILE__).'/../components/UserComponent.php';

$session = SessionService::getSessionObj("user");

if($session->getRole() != 'Admin'){
  header('Location: ./home.php');
}
 $students = UserService::findAll();

$success = false;
$isValid = true;
if(isset($_GET["code"])){
  if($_GET["code"] == 200){ $success = true; }
  if($_GET["code"] == 41){ $isValid = false; }
}
?>

<div style="padding: 20px;">
    <div class="card">
       <div class="card-body">
          <?php if($success): ?>
            <div class="alert alert-success  alert-dismissible" role="alert" >
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                Deleted Successfully
            </div>
           <?php endif; ?>
           <?php if(!$isValid): ?>
            <div class="alert alert-danger  alert-dismissible"  role="alert" >
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                Cannot delete your only admin
            </div>
           <?php endif; ?>
            <div class="row"> 
              <?=UserComponent::userDatagrid($students, 'Users')?>
            </div>
       </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
