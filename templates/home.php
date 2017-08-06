
<?php $title="Home"?>
<?php 
include 'navigation.php';

require_once dirname(__FILE__).'/../services/StudentService.php';
require_once dirname(__FILE__).'/../services/ClassroomService.php';
require_once dirname(__FILE__).'/../services/TeacherService.php';
require_once dirname(__FILE__).'/../services/SubjectService.php';

$students = StudentService::findAll();
$classrooms = ClassroomService::findAll();
$teachers = TeacherService::findAll();
$subjects = SubjectService::findAll();


?>
<div style="padding: 20px;">
  <div class="alert <?=(count($subjects) < 1 || count($classrooms) > 1 || count($teachers) > 1 )? 'alert-danger' :'alert-success'?> alert-dismissible fade in" role="alert">
        <h4 id="oh-snap!-you-got-an-error!">Welcome <?= ucfirst(SessionService::getSessionObj("user")->getUsername()) ?></h4>
        <?php if(count($students) < 1 || count($classrooms) > 1 || count($teachers) > 1 || count($subjects)> 1): ?>
            <p>Seems like you have some configurations to do</p>
            <div class="row">
            <div class="col-sm-6">
                <div class="list-group">
                <?php if(count($teachers) < 1): ?>
                 <a href="#" class="list-group-item">
                    <span class="badge">14</span> Add Teachers
                </a>
                <?php endif; ?>
                <?php if(count($subjects) < 1): ?>
                   <a href="#" class="list-group-item">
                    <span class="badge">14</span> Add Subjects
                   </a>
                <?php endif; ?>
                <?php if(count($classrooms) < 1): ?>
                   <a href="#" class="list-group-item">
                    <span class="badge">14</span> Add Classrooms
                    </a>
                <?php endif; ?>
                <?php if(count($students) < 1): ?>
                   <a href="#" class="list-group-item">
                    <span class="badge">14</span>Add Students
                   </a>
                <?php endif; ?>
               </div>
            </div>
        <?php endif; ?>             
        
   </div>
   </div>
   <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-blue-light">
                <div class="card-body">
                    <i class="icon fa fa-child fa-4x"></i>
                    <div class="content">
                    <div class="title">Students</div>
                    <div class="value"><?=count($students)?></div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-blue-light">
                <div class="card-body">
                    <i class="icon fa fa-female fa-4x"></i>
                    <div class="content">
                    <div class="title">Teachers</div>
                    <div class="value"><?=count($teachers)?></div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-green-light">
                <div class="card-body">
                    <i class="icon fa fa-user-plus fa-4x"></i>
                    <div class="content">
                    <div class="title">Classrooms</div>
                    <div class="value"><?=count($classrooms)?></div>
                    </div>
                </div>
                </a>
           </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <a class="card card-banner card-green-light">
                <div class="card-body">
                    <i class="icon fa fa-book fa-4x"></i>
                    <div class="content">
                    <div class="title">Subjects</div>
                    <div class="value"><?=count($subjects)?></div>
                    </div>
                </div>
                </a>
           </div>
    </div>
</div>

    <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card card-mini">
            <div class="card-header">
                <div class="card-title">Recently Added Students</div>
                <ul class="card-action">
                <li>
                    <a href="/">
                    <i class="fa fa-refresh"></i>
                    </a>
                </li>
                </ul>
            </div>
            <div class="card-body no-padding table-responsive">
                <table class="table card-table">
                <thead>
                    <tr>
                    <th>Student</th>
                    <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>MicroSD 64Gb</td>
                    <td class="right">12</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
        
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card card-mini">
                <div class="card-header">
                    <div class="card-title">Recently Added Teachers</div>
                    <ul class="card-action">
                    <li>
                        <a href="/">
                        <i class="fa fa-refresh"></i>
                        </a>
                    </li>
                    </ul>
                </div>
                <div class="card-body no-padding table-responsive">
                    <table class="table card-table">
                    <thead>
                        <tr>
                        <th>Student</th>
                        <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>MicroSD 64Gb</td>
                        <td class="right">12</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
<?php require_once("footer.php"); ?>
