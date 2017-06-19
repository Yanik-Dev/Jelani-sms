<?php 
$title="Subjects";
require './navigation.php';
require_once dirname(__FILE__).'/../services/SubjectService.php';
require_once dirname(__FILE__).'/../components/SubjectComponent.php';

$subjects = SubjectService::findAll();
?>

<div style="padding: 20px;">
    <div class="card">
       <div class="card-body">
            <div class="row"> 
              <?= SubjectComponent::datagrid($subjects)?>
            </div>
       </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
