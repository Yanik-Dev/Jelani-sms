
<?php $title=(isset($_GET['id']))?'Edit Student':"New Student"; ?>
<?php 
include 'navigation.php';
require_once dirname(__FILE__).'/../services/StudentService.php';
require_once dirname(__FILE__).'/../services/GuardianService.php';
require_once dirname(__FILE__).'/../services/ClassroomService.php';
require_once dirname(__FILE__).'/../models/Classroom.php';
require_once dirname(__FILE__).'/../models/Student.php';
require_once dirname(__FILE__).'/../models/Guardian.php';
require_once dirname(__FILE__).'/../components/StudentComponent.php';

$student=new Student();
$guardian=new Guardian();
$guardians = [];

$classes = ClassroomService::findAll();

if(isset($_GET['id'])){
    $student = StudentService::findOne($_GET['id']);
}

if(isset($_GET['id'])){
    $guardians = GuardianService::findByStudent($_GET['id']);
    //$guardian= GuardianService::findOne($_GET['id'])
}

?>


<div style="padding: 20px;">
    <a href="./student-view.php" class="btn btn-default btn-xs">Back to View</a>
<div class="card">
    <div class="card-body">
<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" id='a' class="active"><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Basic Information</a></li>
        <?php if(isset($_GET['id'])): ?>
        <li role="presentation" ><a href="#parent" id="p" aria-controls="parent" role="tab" data-toggle="tab">Parent Information</a></li>
        <?php endif;?>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="info">
           <div class="row"> 
             <?= StudentComponent::studentForm($student, $classes); ?>
           </div>        
        </div>
        <?php if(isset($_GET['id'])): ?>
        <div role="tabpanel" class="tab-pane" id="parent">
            <div class="row"> 
              <?= StudentComponent::parentComponent($guardians, $guardian); ?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>
</div>
</div></div>


<?php require_once("footer.php"); ?>
<script>
  $().ready(function(){
      $.validate({
          validateOnBlur : false,
          modules : 'html5'
      });
      /*$('#p').trigger('click');
      ('#pnew').trigger('click');*/
  });
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>
