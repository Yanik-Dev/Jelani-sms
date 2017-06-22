
<?php $title=(isset($_GET['id']))?'Edit Subject':"New Subject"; ?>
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

?>


<div style="padding: 20px;">
    <a href="./classroom-view.php" class="btn btn-default btn-xs">Back to View</a>


           <div class="row"> 
             <?= ClassroomComponent::classForm($class, $forms, $teachers, $subjects); ?>
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
