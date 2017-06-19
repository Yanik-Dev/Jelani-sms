
<?php $title=(isset($_GET['id']))?'Edit Subject':"New Subject"; ?>
<?php 
include 'navigation.php';
require_once dirname(__FILE__).'/../services/ClassService.php';
require_once dirname(__FILE__).'/../services/TeacherService.php';
require_once dirname(__FILE__).'/../models/Classroom.php';
require_once dirname(__FILE__).'/../components/ClassroomComponent.php';


$class = new Classroom();

if(isset($_GET['id'])){
    $class = ClassService::findOne($_GET['id']);
}


?>


<div style="padding: 20px;">
    <a href="./student-view.php" class="btn btn-default btn-xs">Back to View</a>


           <div class="row"> 
             <?= ClassroomComponent::classForm($class); ?>
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
