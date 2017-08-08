
<?php $title=(isset($_GET['id']))?'Edit Teacher':"New Teacher"; ?>
<?php 
include 'navigation.php';
require_once dirname(__FILE__).'/../services/TeacherService.php';
require_once dirname(__FILE__).'/../models/Teacher.php';
require_once dirname(__FILE__).'/../components/TeacherComponent.php';

$teacher=new Teacher();


if(isset($_GET['id'])){
    $teacher = TeacherService::findOne($_GET['id']);
}

$errors = [];
$success = false;
if(isset($_GET["code"])){
    if($_GET["code"] == 403){
        $errors[0] = "Server error. Please contact admin";
    }
    if($_GET["code"] == 409){
        $errors[0] ="Teacher already exist";
    }
    if($_GET["code"] == 200){
        $success = true;
    }
}
?>


<div style="padding: 20px;">
    <a href="./Teacher-view.php" class="btn btn-default btn-xs">Back to View</a>
<div class="card">
    <div class="card-body">
<div role="tabpanel">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" id='a' class="active"><a href="#info" aria-controls="home" role="tab" data-toggle="tab">Information</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="info">
           <div class="row"> 
             <?= TeacherComponent::teacherForm($teacher, $errors, $success); ?>
           </div>        
        </div>
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
        $('#datetimepicker2').datetimepicker();

    });
</script>
