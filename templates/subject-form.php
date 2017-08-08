
<?php 
$title=(isset($_GET['id']))?'Edit Subject':"New Subject"; 
include 'navigation.php';
require_once dirname(__FILE__).'/../services/SubjectService.php';
require_once dirname(__FILE__).'/../services/TeacherService.php';
require_once dirname(__FILE__).'/../models/Subject.php';
require_once dirname(__FILE__).'/../components/SubjectComponent.php';


$subject = new Subject();
$teachers = TeacherService::findAll();
if(isset($_GET['id'])){
    $subject = SubjectService::findOne($_GET['id']);

}

$errors = [];
$success = false;
if(isset($_GET["code"])){
    if($_GET["code"] == 403){
        $errors[0] = "Server error. Please contact admin";
    }
    if($_GET["code"] == 409){
        $errors[0] ="Subject already exist";
    }
    if($_GET["code"] == 200){
        $success = true;
    }
}
?>


<div style="padding: 20px;">
    <a href="./subject-view.php" class="btn btn-default btn-xs">Back to View</a>
    <div class="row"> 
      <?= SubjectComponent::form($subject, $teachers, $errors, $success); ?>
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
