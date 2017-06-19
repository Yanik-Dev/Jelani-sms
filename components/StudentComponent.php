<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class  StudentComponent{
    
    public static function studentDatagrid($students, $title=''){
        $rows = "";
        foreach($students as $student){
           $rows .='  
                <tr>
                <td><img class="profile-img" style="width:50px; height:50px; border-radius: 50%;" src="'.(($student->getPhoto()!=null)?$student->getPhoto():'../assets/img/profile.png').'"></td>
                <td>'.$student->getSRN().'</td>
                <td>'.$student->getFirstName().' '.$student->getLastName().'</td> 
                <td>'.$student->getGender().'</td>
                <td>'.date("F j, Y", strtotime($student->getDateOfBirth())) .'</td>
                <td>'.$student->getClass()->getName() .'</td>
                <td>
                 <a href="./student-form.php?id='.$student->getId().'" class="btn btn-primary btn-xs">Edit</a>
                 <a href="../actions/student-actions.php?id='.$student->getId().'&action=delete" class="btn btn-danger btn-xs">Delete</a>
                 <a href="button" class="btn btn-default btn-xs">Grade</a>
             </td>
            </tr>';
        }
        echo' 
            <div class="col-xs-12">
              <div class="card">
                <div class="card-header">
                  '.$title.'
                </div>
                <div class="card-body no-padding">
                  <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>SRN</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Date Of Birth</th>
                            <th>Class</th>
                            <th> 
                            <a href="./student-form.php" 
                                      class="btn btn-success btn-xs" 
                                      style="margin: 0px">
                                        <i class="glyphicon glyphicon-plus"></i> New
                              </a>
                              <a href="./student-form.php" 
                                      class="btn btn-default btn-xs" 
                                      style="margin: 0px">
                                        <i class="glyphicon glyphicon-print"></i> Print
                              </a></th>
                        </tr>
                    </thead>
                    <tbody>
                      '.$rows.'
                    </tbody>
                </table>
                </div>
              </div>
            </div>';
    }
    
    public static function studentForm ($student, $classes=[], $errors = []){
        $options = "";
        $errorElement ="";
        
        #populate option with classes for dropdown menu
        foreach($classes as $class){
           if($student->getClass() != null){
            if($student->getClass()->getId() == $class->getId()){
                 $options .='<option value="'.($class->getId().'" selected>'.$class->getName()).'</option>';
                 continue;
            }
           }
           $options .='<option value="'.($class->getId().'">'.$class->getName()).'</option>';
        }
        
        #get errors if any
        if(count($errors)>0){
            $i=0;
            foreach ($errors as $err){
              $errorMsg .= $i.'. '.$err.'\n';
              $i++;
            }
            $errorElement ='<div class="alert alert-danger  alert-dismissible" role="alert" id="err-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">Ã—</span></button>
                            <strong>Oops Invalid Fields!</strong> Check form and try submitting again.
                            '.$errorMsg.'
                            </div>';
        }
                
        return '
        <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form id="studentForm" 
                        action="../actions/student-actions.php"
                        method="post" 
                        enctype="multipart/form-data"
                        class="form form-horizontal ajax-data">
                    <div class="section">                       
                        <div class="section-body">
                            <div class="alert alert-danger  alert-dismissible" role="alert" style="display:none" id="error-alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                                <strong>Oops!</strong> There was an unexpected error 
                             </div>
                            '.$errorElement.'
                            
                            <div class="alert alert-success  alert-dismissible" style="display:none" role="alert" id="success-alert">
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                               Inserted Successfully
                            </div>
                         <div class="form-group">
                            <input type="hidden" name = "id" value="'.(($student->getId()!=null)?$student->getId():'').'">
                            <div  class="col-md-3"> 
                                <label style="width:100%">Photo</label>
                                <img id="img-output"
                                    src="'.(($student->getPhoto()!=null)?$student->getPhoto():'../assets/img/profile.png').'" 
                                    class="img-circle" width="70px" height="70px">
                            </div>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                <input type="file" name="file" id="exampleInputFile" onchange="previewImage(event)">
                                <p class="help-block">Select a photo to upload</p>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">SRN</label>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                    <input type="text" 
                                       value="'.(($student->getSRN()!=null)?$student->getSRN():'').'"
                                       class="form-control"  
                                       data-validation-length="10-11" 
                                       data-validation="length" 
                                       name="srn" 
                                       placeholder="SRN">
                               </div>                              
                             </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-9">
                            <div class="col-md-4">
                                <input type="text" 
                                       value="'.(($student->getFirstName()!=null)?$student->getFirstName():'').'"
                                       class="form-control" 
                                       name="first_name" 
                                       placeholder="First Name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" 
                                       value="'.(($student->getLastName()!=null)?$student->getLastName():'').'"
                                       class="form-control" 
                                       name="last_name" 
                                       placeholder="Surname">
                            </div>
                            <div class="col-md-4">
                                <input type="text" 
                                       value="'.(($student->getMiddleName()!=null)?$student->getMiddleName():'').'"
                                       class="form-control" 
                                       name="middle_name" 
                                       placeholder="Middle Name">
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date of Birth</label>
                            <div class="col-md-9">
                               <div class="col-md-6">
                                    <div class="input-group date" id="datetimepicker1" style="z-index: 99999999">
                                        <input type="text" name="date_of_birth" class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Gender</label>
                            <div class="col-md-9">
                            <div class="col-md-6">  
                                <div class="radio radio-inline">
                                    <input type="radio" 
                                           name="gender" 
                                           id="radio10" 
                                           value="Male"
                                           '.(($student->getGender()!=null)?($student->getGender()=='Male')?"checked='checked'":"" :"").'
                                           >
                                    <label for="radio10">
                                        Male
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <input 
                                        type="radio" 
                                        name="gender" 
                                        id="radio11" 
                                        value="Female" 
                                        '.(($student->getGender()!=null)?($student->getGender()=='Female')?"checked='checked'":"" :"").'>
                                    <label for="radio11">
                                        Female
                                    </label>
                                </div>
                            </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-3 control-label">Class</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <select class="select2" name="class">
                                    '.$options.'
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                  <input type="email" 
                                         value="'.(($student->getEmail()!=null)?$student->getEmail():'').'"
                                         name="email" 
                                         class="form-control" 
                                         placeholder="johndoe@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contact Numbers</label>
                            <div class="col-md-9">
                            <div class="col-md-6">
                                <input type="text" 
                                       value="'.(($student->getContactNo1()!=null)?$student->getContactNo1():'').'"
                                       class="form-control" 
                                       name="contact_no1"
                                       placeholder="(000) 000 0000">
                            </div>
                            <div class="col-md-6"> 
                                <input type="text" 
                                       value="'.(($student->getContactNo2()!=null)?$student->getContactNo2():'').'"
                                       name="contact_no2"
                                       class="form-control" 
                                       placeholder="(000) 000 0000">
                            </div>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Address</label>
                            <div class="col-md-9">
                                <div class="col-md-6"> 
                                    <textarea class="form-control" 
                                              name="address" 
                                              placeholder="street/district, city/town, province">'.(($student->getAddress()!=null)?$student->getAddress():'').'</textarea>
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">'.(($student->getFirstName()!=null)?'Save Changes':'Save').'</button>
                                <button type="reset" class="btn btn-default">Cancel</button>
                            </div> 
                        </div>
                    </div>
                    </div>
                  </form>
                 </div>
                </div>                
                </div>
              ';

    }
    
    public static function parentComponent($guardians, $guardian, $errors=[]){
        $errorElement ="";
        $rows = "";
        
        foreach($guardians as $guard){
            $rows .='<tr>
                 <td>'.$guard->getFirstName().'</td>
                 <td>'.$guard->getProfession().'</td>
                 <td>'.$guard->getType().'</td>
                 <td>'.$guard->getContactNo1().' '.$guard->getContactNo2().'</td>
                 <td>'.$guard->getEmail().'</td>
                 <td>
                  <a href="" class="btn btn-default btn-xs">Edit</a>
                  <a href="" class="btn btn-default btn-xs">Delete</a>
                 </td>
             </tr>';
        }
        
        #get errors if any
        if(count($errors)>0){
            $i=0;
            foreach ($errors as $err){
              $errorMsg .= $i.'. '.$err.'\n';
              $i++;
            }
            $errorElement ='<div class="alert alert-danger  alert-dismissible" role="alert" id="err-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">Ã—</span></button>
                            <strong>Oops Invalid Fields!</strong> Check form and try submitting again.
                            '.$errorMsg.'
                            </div>';
        }
        
        return '
            <div class="col-xs-12">
            <div class="card">
              <div class="card-header">
                Guardian
              </div>
              <div class="card-body no-padding">
                <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Profession</th>
                          <th>Guardian Type</th>
                          <th>Contact Numbers</th>
                          <th>Email</th>
                          <th>
                              <button type="button" 
                                      id="pnew"
                                      class="btn btn-clear btn-xs" 
                                      data-toggle="modal" 
                                      data-target="#myModal"
                                      style="margin: 0px">
                                        <i class="glyphicon glyphicon-plus"></i> New
                              </button>
                          </th>
                      </tr>
                  </thead>
                  <tbody>
                      '.$rows.'
                  </tbody>
              </table>
              </div>
            </div>
            </div>


           <div class="modal fade" id="myModal" aria-labelledby="myModalLabel">
              <div class="modal-dialog">
                <div class="modal-content">
                 
                '.$errorElement.'
                  <form action="../actions/parent-actions.php" class="ajax" id="guardianForm" method="post">
                      <input type="hidden" value="'.(($guardian->getId()!=null) ?$guardian->getId(): '').'" >
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"></h4>
                      </div>
                      <div class="modal-body" style="background-color: #fff;">
                          <div class="row">
                          <div class=" form-group col-md-6">
                              <label class="control-label">Name</label>
                              <input type="text" class="form-control" value="'.(($guardian->getFirstName()!=null) ?$guardian->getFirstName(): '').'" data-validation="required" name="name" placeholder="">
                          </div>
                          <div class="form-group  col-md-6">
                              <label class="control-label">Profession</label>
                              <input type="text" class="form-control" value="'.(($guardian->getProfession()!=null) ?$guardian->getProfession(): '').'" data-validation="required" name="profession" placeholder="" >
                          </div>
                         <div class="form-group col-md-12">
                              <label class="control-label">Guardian Type</label>
                              <select class="select2" name="class" style="width: 100% !important;">
                                  <option value="Parent">Parent</option>
                                  <option value="Sibling">Sibling</option>
                                  <option value="Grand Parent">Grand Parent</option>
                                  <option value="Relative">Relative</option>
                                  <option value="Family Friend">Family Friend</option>
                              </select>
                          </div>   

                          <div class=" form-group col-md-12">
                              <div class="radio radio-inline">
                                  <input type="radio" 
                                     name="gender" id="radio3" 
                                     value="Male"
                                     '.(($guardian->getGender()!=null)?($guardian->getGender()=='Male')?"checked='checked'":"" :"").'   
                                     >
                                  <label for="radio3">
                                      Male
                                  </label>
                              </div>
                              <div class="radio radio-inline">
                                  <input type="radio" 
                                         name="gender" id="radio4" 
                                         value="Female"
                                      '.(($guardian->getGender()!=null)?($guardian->getGender()=='Female')?"checked='checked'":"" :"").' 
                                    >
                                  <label for="radio4">
                                      Female
                                  </label>
                              </div>
                           </div>

                            <div class=" form-group col-md-6">
                              <label class="control-label">Contact Number</label>
                              <input type="text" class="form-control" value="'.(($guardian->getContactNo1()!=null) ?$guardian->getContactNo1(): '').'" data-validation="required" placeholder="(000) 000 0000" pattern="[789][0-9]{9}"> 
                            </div>

                            <div class=" form-group col-md-6">
                              <label class="control-label">Contact Number</label>
                              <input type="text" value="'.(($guardian->getContactNo2()!=null) ?$guardian->getContactNo2(): '').'" data-validation-error-msg="Invalid Phone number" class="form-control" placeholder="(000) 000 0000" pattern="[789][0-9]{9}">
                            </div>

                            <div class=" form-group col-md-12">
                              <input type="email" class="form-control" value="'.(($guardian->getEmail()!=null) ?$guardian->getEmail(): '').'" data-validation="required email" placeholder="johndoe@example.com">  
                            </div>              
                          </div>
                      </div>
                      <div class="modal-footer">
                       <button type="submit"  class="btn btn-sm btn-default" >'.(($guardian->getFirstName()!=null)?'Save Changes':'Save').'</button>
                       <button type="button" class="btn btn-sm btn-success" data-dismiss="modal">Cancel</button>
                      </div>  
                   </form>
                </div>
              </div>        
          </div>
          
        ';
    }
}
