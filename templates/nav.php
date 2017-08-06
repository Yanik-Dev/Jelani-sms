  <nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <a class="navbar-brand" href="#"><span class="highlight">Jelani</span> Admin</a>
        </li>
        <li>
          <button type="button" class="navbar-toggle">
            <img class="profile-img" src="<?= (SessionService::getSessionObj("user")->getRole() == "Admin")?'.././assets/img/admin.png':'.././assets/vendor/images/profile.png'?>">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title"><?=$title?></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown profile">
          <a href="/html/pages/profile.html" class="dropdown-toggle"  data-toggle="dropdown">
            <img class="profile-img" src="<?= (SessionService::getSessionObj("user")->getRole() == "Admin")?'.././assets/img/admin.png':'.././assets/vendor/images/profile.png'?>">
            <div class="title">Profile</div>
          </a>
          <div class="dropdown-menu">
            <div class="profile-info">
              <h4 class="username"><?= ucfirst(SessionService::getSessionObj("user")->getUsername())?></h4>
            </div>
            <ul class="action">
              <li>
                <a href="#">
                  Setting
                </a>
              </li>
              <li>
                <a href="./home.php?logout=true">
                  Logout
                </a>
              </li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
