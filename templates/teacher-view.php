<?php 
$title ="Teachers";
require './navigation.php';
require_once dirname(__FILE__).'/../services/TeacherService.php';
require_once dirname(__FILE__).'/../components/TeacherComponent.php';


$teachers = TeacherService::findAll();
?>

<div style="padding: 20px;">
    <div class="card">
       <div class="card-body">
            <div class="row"> 
              <?= TeacherComponent::datagrid($teachers)?>
            </div>
       </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
