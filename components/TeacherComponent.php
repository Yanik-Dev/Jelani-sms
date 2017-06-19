<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class  TeacherComponent{
    
    public static function datagrid($teachers){
        $rows = "";
        foreach($teachers as $teacher){
           $rows .='  
                <tr>
                <td><img class="profile-img" style="width:50px; height:50px; border-radius: 50%;" src="'.(($teacher->getPhoto()!=null)?$teacher->getPhoto():"../assets/img/profile.png").'"></td>
                <td>'.$teacher->getTRN().'</td>
                <td>'.$teacher->getFirstName().' '.$teacher->getLastName().'</td>
                <td>'.date("F j, Y", strtotime($teacher->getDateOfEmployment())).'</td>
                <td>
                 <a href="./teacher-form.php?id='.$teacher->getId().'" class="btn btn-primary btn-xs">Edit</a>
                 <a href="../actions/teacher-actions.php?id='.$teacher->getId().'&action=delete" class="btn btn-danger btn-xs">Delete</a>
             </td>
            </tr>';
        }
        echo' 
            <div class="col-xs-12">
              <div class="card">
                <div class="card-header">
                  Teachers
                </div>
                <div class="card-body no-padding">
                  <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>TRN</th>
                            <th>Name</th>
                            <th>Employment Date</th>
                            <th> 
                            <a href="./teacher-form.php" 
                                      class="btn btn-success btn-xs" 
                                      style="margin: 0px">
                                        <i class="glyphicon glyphicon-plus"></i> New
                              </a>
                              <a href="" 
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
    
    public static function teacherForm ($teacher, $errors = []){
        $errorElement = "";
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
                  <form id="teacherForm" 
                        action="../actions/teacher-actions.php"
                        method="post" 
                        enctype="multipart/form-data"
                        class="form form-horizontal">
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
                            <input type="hidden" name="id" value="'.(($teacher->getId()!=null) ?$teacher->getId(): '').'" >
                         <div class="form-group">
                            <div  class="col-md-3"> 
                                <label style="width:100%">Photo</label>
                                <img id="img-output"
                                    src="'.(($teacher->getPhoto()!=null)?$teacher->getPhoto():'../assets/img/profile.png').'" 
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
                            <label class="col-md-3 control-label">TRN</label>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                    <input type="text" 
                                       value="'.(($teacher->getTRN()!=null)?$teacher->getTRN():'').'"
                                       class="form-control"  
                                       data-validation-length="10-11" 
                                       data-validation="length" 
                                       name="trn" 
                                       placeholder="TRN">
                               </div>                              
                             </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name</label>
                            <div class="col-md-9">
                            <div class="col-md-4">
                                <input type="text" 
                                       value="'.(($teacher->getFirstName()!=null)?$teacher->getFirstName():'').'"
                                       class="form-control" 
                                       name="first_name" 
                                       placeholder="First Name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" 
                                       value="'.(($teacher->getLastName()!=null)?$teacher->getLastName():'').'"
                                       class="form-control" 
                                       name="last_name" 
                                       placeholder="Surname">
                            </div>
                            <div class="col-md-4">
                                <input type="text" 
                                       value="'.(($teacher->getMiddleName()!=null)?$teacher->getMiddleName():'').'"
                                       class="form-control" 
                                       name="middle_name" 
                                       placeholder="Middle Name">
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date of employment</label>
                            <div class="col-md-9">
                               <div class="col-md-6">
                                    <div class="input-group date" id="datetimepicker2" style="z-index: 99999998">
                                        <input type="text" name="date_of_employment" class="form-control" />
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
                                           '.(($teacher->getGender()!=null)?($teacher->getGender()=='Male')?"checked='checked'":"" :"").'
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
                                        '.(($teacher->getGender()!=null)?($teacher->getGender()=='Female')?"checked='checked'":"" :"").'>
                                    <label for="radio11">
                                        Female
                                    </label>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Marital Status</label>
                            <div class="col-md-9">
                            <div class="col-md-12">  
                                <div class="radio radio-inline">
                                    <input type="radio" 
                                           name="marital_status" 
                                           id="single_rbtn" 
                                           value="Single"
                                           '.(($teacher->getMaritalStatus()!=null)?($teacher->getMaritalStatus()=='Single')?"checked='checked'":"" :"").'
                                           >
                                    <label for="single_rbtn">
                                        Single
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <input 
                                        type="radio" 
                                        name="marital_status" 
                                        id="married_rbtn" 
                                        value="Married" 
                                        '.(($teacher->getMaritalStatus()!=null)?($teacher->getMaritalStatus()=='Married')?"checked='checked'":"" :"").'>
                                    <label for="married_rbtn">
                                        Married
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <input 
                                        type="radio" 
                                        name="marital_status" 
                                        id="separated_rbtn" 
                                        value="Separated" 
                                        '.(($teacher->getMaritalStatus()!=null)?($teacher->getMaritalStatus()=='Separated')?"checked='checked'":"" :"").'>
                                    <label for="separated_rbtn">
                                        Separated
                                    </label>
                                </div>
                                <div class="radio radio-inline">
                                    <input 
                                        type="radio" 
                                        name="marital_status" 
                                        id="divorced_rbtn" 
                                        value="Divorced" 
                                        '.(($teacher->getMaritalStatus()!=null)?($teacher->getMaritalStatus()=='Divorced')?"checked='checked'":"" :"").'>
                                    <label for="divorced_rbtn">
                                        Divorced
                                    </label>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                  <input type="email" 
                                         value="'.(($teacher->getEmail()!=null)?$teacher->getEmail():'').'"
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
                                       value="'.(($teacher->getContactNo1()!=null)?$teacher->getContactNo1():'').'"
                                       class="form-control" 
                                       name="contact_no1"
                                       placeholder="(000) 000 0000">
                            </div>
                            <div class="col-md-6"> 
                                <input type="text" 
                                       value="'.(($teacher->getContactNo2()!=null)?$teacher->getContactNo2():'').'"
                                       class="form-control" 
                                       name="contact_no2"
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
                                              placeholder="street/district, city/town, province">'.(($teacher->getAddress()!=null)?$teacher->getAddress():'').'</textarea>
                                </div>    
                            </div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">'.(($teacher->getFirstName()!=null)?'Save Changes':'Save').'</button>
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
    

}
