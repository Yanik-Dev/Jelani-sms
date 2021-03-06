<div class="app app-default">
<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="#"><span class="highlight">JELANI</span> Admin</a>
    <button type="button" class="sidebar-toggle">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <li class="<?=($title=='Home')?'active':''?>" >
        <a href="./home.php">
          <div class="icon">
            <i class="fa fa-tasks" aria-hidden="true"></i>
          </div>
          <div class="title">Home</div>
        </a>
      </li>  
      <li class="<?=($title=='Students' || $title=='Edit Student' || $title=='New Student')?'active':''?>">
        <a href="./student-view.php">
          <div class="icon">
            <i class="fa fa-child" aria-hidden="true"></i>
          </div>
          <div class="title">Students</div>
        </a>
      </li>  
      <?php if(SessionService::getSessionObj("user")->getRole() == 'Admin'): ?>
      <li class="<?=($title=='Teachers')?'active':''?>">
          <a href="./teacher-view.php">
          <div class="icon">
            <i class="fa fa-female" aria-hidden="true"></i>
          </div>
          <div class="title">Teachers</div>
        </a>
      </li>  
      <li class="<?=($title=='Subjects' || $title=='Edit Subject' || $title=='New Subject')?'active':''?>">
          <a href="./subject-view.php">
          <div class="icon">
            <i class="fa fa-book" aria-hidden="true"></i>
          </div>
          <div class="title">Subjects</div>
        </a>
      </li>     
      <li class="<?=($title=='Classrooms'|| $title=='Edit Classroom' || $title=='New Classroom')?'active':''?>">
          <a href="./classroom-view.php">
          <div class="icon">
            <i class="fa fa-home" aria-hidden="true"></i>
          </div>
          <div class="title">Classes</div>
        </a>
      </li> 
      <li class="<?=($title=='Users')?'active':''?>">
          <a href="./user-view.php">
          <div class="icon">
            <i class="fa fa-users" aria-hidden="true"></i>
          </div>
          <div class="title">Users</div>
        </a>
      </li> 
    <?php endif; ?>  
    </ul>
  </div>
  <div class="sidebar-footer">
    <ul class="menu">
      <li>
        <a href="/" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-cogs" aria-hidden="true"></i>
        </a>
      </li>
    </ul>
  </div>
</aside>

<div class="app-container">