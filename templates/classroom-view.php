<?php 
$title="Students";
require './navigation.php';
require_once dirname(__FILE__).'/../services/ClassroomService.php';
require_once dirname(__FILE__).'/../components/ClassroomComponent.php';

$classes = ClassroomService::findAll();
?>

<div style="padding: 20px;">
    <div class="card">
       <div class="card-body">
            <div class="row"> 
              <?= ClassroomComponent::classDatagrid($classes)?>
            </div>
       </div>
    </div>
</div>

<?php require_once("footer.php"); ?>