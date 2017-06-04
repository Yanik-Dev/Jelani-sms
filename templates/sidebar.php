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
      <li class="active">
        <a href="./index.html">
          <div class="icon">
            <i class="fa fa-tasks" aria-hidden="true"></i>
          </div>
          <div class="title">Dashboard</div>
        </a>
      </li>  
      <li class="active">
        <a href="./student-view.php">
          <div class="icon">
            <i class="fa fa-child" aria-hidden="true"></i>
          </div>
          <div class="title">Students</div>
        </a>
      </li>  
      <li class="">
        <a href="./index.html">
          <div class="icon">
            <i class="fa fa-female" aria-hidden="true"></i>
          </div>
          <div class="title">Teachers</div>
        </a>
      </li>  
      <li class="">
        <a href="./index.html">
          <div class="icon">
            <i class="fa fa-book" aria-hidden="true"></i>
          </div>
          <div class="title">Subjects</div>
        </a>
      </li>   
       
      <li class="">
        <a href="./index.html">
          <div class="icon">
            <i class="fa fa-female" aria-hidden="true"></i>
          </div>
          <div class="title">Classes</div>
        </a>
      </li>   
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

<script type="text/ng-template" id="sidebar-dropdown.tpl.html">
  <div class="dropdown-background">
    <div class="bg"></div>
  </div>
  <div class="dropdown-container">
    {{list}}
  </div>
</script>

<div class="app-container">