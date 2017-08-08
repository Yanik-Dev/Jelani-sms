<?php 
$title="Students";
require './navigation.php';
require_once dirname(__FILE__).'/../services/StudentService.php';
require_once dirname(__FILE__).'/../services/SessionService.php';
require_once dirname(__FILE__).'/../components/StudentComponent.php';

$session = SessionService::getSessionObj("user");
if($session->getRole() == 'Admin'){
  $students = StudentService::findAll();
}
else if($session->getRole() == 'Teacher'){
  
}

$success = false;
if(isset($_GET["code"])){
  if($_GET["code"] == 200){ $success = true; }
  
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
            <div class="row"> 
              <?= StudentComponent::studentDatagrid($students, 'Students')?>
            </div>
       </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
