<?php
$title = "Jelani - Configurations";
require 'header.php';
require '../components/SetupComponent.php';
require '../services/GradeService.php';


if(isset($_GET['db']) || isset($_GET['account'])){
    
}else{
    header("Location: ./login.php");
}
$availableForms = GradeService::findAllAvailableForms();
?>
<div class="app app-default">
<div class="app-container app-login"> 
  <div class="flex-center">
    <div class="app-header"></div>
    <div class="app-body">      
      <div class="loader-container text-center">
          <div class="icon">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
              </div>
            </div>
          <div class="title">Logging in...</div>
      </div>
      <div class="app-block">
        <div class="app-right-section">
          <div class="app-brand"><span class="highlight">Jelani</span> Setup</div>
          <div class="app-info">
            
            <ul class="list">
              <li>
                <div class="icon">
                  <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                </div>
                <div class="title">Increase <b>Productivity</b></div>
              </li>
              <li>
                <div class="icon">
                  <i class="fa fa-desktop" aria-hidden="true"></i>
                </div>
                <div class="title">Creates <b>Central</b> Management</div>
              </li>
              <li>
                <div class="icon">
                  <i class="fa fa-folder-open" aria-hidden="true"></i>
                </div>
                <div class="title">Provides <b>Structure</b></div>
              </li>
            </ul>
              
          </div>
        </div>
        <div class="app-form">
              <div class="step">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                <?php  if(isset($_GET['db'])): ?>
                    <li role="step" class="active">
                        <a href="#db" id="dbStep" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                            <div class="icon fa fa-database"></div>
                            <div class="heading">
                                <div class="title">Database</div>
                                <div class="description">Setup</div>
                            </div>
                        </a>
                    </li>
                  <?php endif; ?>
                    <li role="step">
                        <a href="#account" role="tab"  id="accountStep" data-toggle="tab" aria-controls="profile">
                            <div class="icon fa fa-user"></div>
                            <div class="heading">
                                <div class="title">Account</div>
                                <div class="description">Setup</div>
                            </div>
                        </a>
                    </li>
                </ul>
                 <!-- Tab panes -->
                <div class="tab-content">
                  <?php  if(isset($_GET['db'])): ?>
                    <div role="tabpanel" class="tab-pane active" id="db">
                        <?= SetupComponent::dbSetup() ?> 
                    </div>
                  <?php endif; ?>
                    <div role="tabpanel" class="tab-pane" id="account">
                       <?= SetupComponent::accountSetup($availableForms) ?> 
                    </div>
                </div>
              </div>
        </div>
      </div>
    </div>
    <div class="app-footer">
    </div>
  </div>
</div>
</div>

<?php include 'footer.php'; ?>

<script>
  $().ready(function(){
      $.validate({
          validateOnBlur : true,
          modules : 'security',
      });
  });
   
</script>
<?php
    if(isset($_GET['db'])){
        echo ' <script>
                $("#dbStep").trigger("click");
              </script>';
    }
    else if (isset($_GET['account'])){
        echo ' <script>
                $("#accountStep").trigger("click");
              </script>';
    }