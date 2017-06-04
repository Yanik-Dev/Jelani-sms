<?php 
$title="Students";
require './navigation.php';
require_once dirname(__FILE__).'/../services/StudentService.php';
require_once dirname(__FILE__).'/../components/StudentComponent.php';

$students = StudentService::findAll();
?>

<div style="padding: 20px;">
    <div class="card">
       <div class="card-body">
            <div class="row"> 
              <?= StudentComponent::studentDatagrid($students, 'Students')?>
            </div>
       </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
