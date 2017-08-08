
<?php $title=(isset($_GET['id']))?'Edit Classroom':"New Classroom"; ?>
<?php 
include 'navigation.php';
require_once dirname(__FILE__).'/../services/ClassroomService.php';
require_once dirname(__FILE__).'/../services/TeacherService.php';
require_once dirname(__FILE__).'/../services/SubjectService.php';
require_once dirname(__FILE__).'/../services/GradeService.php';
require_once dirname(__FILE__).'/../models/Classroom.php';
require_once dirname(__FILE__).'/../components/ClassroomComponent.php';


$class = new Classroom();
$teachers = TeacherService::findAll();
$subjects = SubjectService::findAll();
$forms = GradeService::findAll();
if(isset($_GET['id'])){
    $class = ClassroomService::findOne($_GET['id']);
}

$errors = [];
$success = false;
if(isset($_GET["code"])){
    if($_GET["code"] == 403){
        $errors[0] = "Server error. Please contact admin";
    }
    if($_GET["code"] == 409){
        $errors[0] ="Classroom already exist";
    }
    if($_GET["code"] == 200){
        $success = true;
    }
}
?>


<div style="padding: 20px;">
    <a href="./classroom-view.php" class="btn btn-default btn-xs">Back to View</a>


           <div class="row"> 
             <?= ClassroomComponent::classForm($class, $forms, $teachers, $subjects, $errors, $success); ?>
           </div> 

</div>


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
