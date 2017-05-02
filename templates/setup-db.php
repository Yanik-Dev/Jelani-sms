<?php
$title = "Jelani - Database Configurations";
include 'header.php';
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
          <div class="form-suggestion">
            Configure Database settings
          </div>
          <form action="/" method="POST">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">
                  <i class="fa fa-server" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="server" placeholder="Server" aria-describedby="basic-addon1">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon2">
                  <i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" class="form-control" name="username" placeholder="Username" aria-describedby="basic-addon2">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon3">
                  <i class="fa fa-key" aria-hidden="true"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password" aria-describedby="basic-addon3">
              </div>
              <div class="text-center">
                  <input type="submit" class="btn btn-primary btn-submit" value="Test Connection">   
                  <div class="form-line">
                    <div class="title">OR</div>
                  </div>
                  <input type="submit" class="btn btn-success btn-submit" value="Save">
              </div>
          </form>
        </div>
      </div>
    </div>
    <div class="app-footer">
    </div>
  </div>
</div>
</div>

<?php include 'header.php'; ?>