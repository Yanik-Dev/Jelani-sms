
<?php $title=(isset($_GET['id']))?'Edit User':"New Admin User"; ?>
<?php 
include 'navigation.php';
require_once dirname(__FILE__).'/../services/UserService.php';
require_once dirname(__FILE__).'/../models/User.php';
require_once dirname(__FILE__).'/../components/UserComponent.php';

$user=new User();

if(isset($_GET['id'])){
    $user = UserService::findOne($_GET['id']);
}
$success = false;
$errors = [];
if(isset($_GET["code"])){
    if($_GET["code"] == 403){
        $errors[0] = "Server error. Please contact admin";
    }
    if($_GET["code"] == 409){
        $errors[0] ="Admin User already exist";
    }
    if($_GET["code"] == 200){
        $success = true;
    }
}
?>

<div style="padding: 20px;">
    <a href="./user-view.php" class="btn btn-default btn-xs">Back to View</a>
<div class="card">
    <div class="card-body">
  
        <div class="row"> 
            <?= UserComponent::userForm($user, $errors, $success); ?>
        </div>        
    
   </div>
</div>
</div>



<?php require_once("footer.php"); ?>
<script>
  $().ready(function(){
      $.validate({
          validateOnBlur : true,
          modules : 'location, date, security, file',
      });

      /*$('#p').trigger('click');
      ('#pnew').trigger('click');*/
  });
   
</script>
