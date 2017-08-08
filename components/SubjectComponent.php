<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class  SubjectComponent{
    
    public static function datagrid($subjects = []){
        $rows = "";
                
        foreach($subjects as $subject){
           $teachers =$subject->getTeachers();
           $teacherList = "";
           foreach($teachers as $teacher){
            $teacherList .= $teacher->getFirstName().' '.$teacher->getLastName()."<br />";
           }
           $rows .='  
            <tr>
                <td>'.$subject->getId().'</td> 
                <td>'.$subject->getName().'</td>
                <td>'.$subject->getCode().'</td>
                <td>'.$teacherList.'</td>
                <td>
                 <a href="./subject-form.php?id='.$subject->getId().'" class="btn btn-primary btn-xs">Edit</a>
                </td>
            </tr>';
        }
        echo' 
            <div class="col-xs-12">
              <div class="card">
                <div class="card-header">
                  Subjects
                </div>
                <div class="card-body no-padding">
                  <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Subject name</th>
                            <th>Subject Code</th>
                            <th>Teachers</th>
                            <th> 
                            <a href="./subject-form.php" 
                                      class="btn btn-success btn-xs" 
                                      style="margin: 0px">
                                        <i class="glyphicon glyphicon-plus"></i> New
                              </a>
                             </th>
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
    
    public static function form ($subject,$teachers=[], $errors = [], $success=false){
        
        $errorElement ="";
        $teacherOptions = "";
        $errorMsg ="";
        
        #populate option with teachers in dropdown menu
        foreach($teachers as $teacher){
          $found= 0;
          if(count($subject->getTeachers()) > 0){
               foreach($subject->getTeachers() as $teach){
                    if($teach->getId() == $teacher->getId()){
                        $found = 1;
                        break;   
                    } 
               }
           }
           if($found){
               $teacherOptions .='<option value="'.($teacher->getId().'" selected>'.$teacher->getFirstName().' '.$teacher->getLastName()).'</option>';
           }else{
               $teacherOptions .='<option value="'.($teacher->getId().'">'.$teacher->getFirstName().' '.$teacher->getLastName()).'</option>';
           }
        }
        
        #get errors if any
        if(count($errors)>0){
            $i=0;
            foreach ($errors as $err){
              $errorMsg .= $err;
              $i++;
            }
            $errorElement ='<div class="alert alert-danger  alert-dismissible" role="alert" id="err-alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">Ã—</span></button>
                            <strong>Oops!</strong> 
                            '.$errorMsg.'
                            </div>';
        }
                
        return '
        <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <form id="studentForm" 
                        action="../actions/subject-actions.php"
                        method="post" 
                        class="form form-horizontal">
                    <input type="hidden" value="'.(($subject->getId()!=null) ?$subject->getId(): '').'" >
                    <div class="section">                       
                        <div class="section-body">
                            '.$errorElement.'
                            
                            '.(($success)?'
                            <div class="alert alert-success  alert-dismissible"  role="alert" >
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                               Inserted Successfully
                            </div>':'').'
                          <input type="hidden" name="id" value="'.(($subject->getId()!=null) ?$subject->getId(): '').'" >
                         
                        <div class="form-group">
                            <label class="col-md-3 control-label"> Subject Name</label>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                    <input type="text" 
                                       value="'.(($subject->getName()!=null)?$subject->getName():'').'"
                                       class="form-control"  
                                       data-validation-length="4-30" 
                                       data-validation="length" 
                                       name="name" 
                                       placeholder="Subject Name">
                               </div>                              
                             </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Subject Code</label>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                    <input type="text" 
                                       value="'.(($subject->getCode()!=null)?$subject->getCode():'').'"
                                       class="form-control"  
                                       name="code" 
                                       placeholder="Subject Code">
                               </div>                              
                             </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Subject Teacher(s) </label>
                            <div class="col-md-9">
                                <div class="col-md-12">
                                    <select class="select2" name="teachers[]" multiple>
                                    '.$teacherOptions.'
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        
                    <div class="form-footer">
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">'.(($subject->getId()!=null)?'Save Changes':'Save').'</button>
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
