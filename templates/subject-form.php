
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
?>


<div style="padding: 20px;">
    <a href="./subject-view.php" class="btn btn-default btn-xs">Back to View</a>
    <div class="row"> 
      <?= SubjectComponent::form($subject, $teachers); ?>
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
