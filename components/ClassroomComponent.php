<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class  ClassroomComponent{
    
    public static function classDatagrid($classes){
        $rows = "";
        $subjects = [];
        $teachers = [];
        
        $i=0;
        foreach($classes as $class){
            $string = "";
            foreach($class->getTeachers() as $teacher){
                $string .= $teacher->getFirstName().' '.$teacher->getLastName().'<br />';
               
            }
            $teachers[$i] = $string;
            $i++;
        }
        $i=0;
        foreach($classes as $class){
        $string = "";
            foreach($class->getSubjects() as $subject){
                $string .= $subject->getName().'<br />';
            }
            $subjects[$i] = $string;
            $i++;
        }
        $i=0;
        
        foreach($classes as $class){
           $rows .='  
            <tr>
                <td>'.$class->getName().'</td>
                <td>'.$class->getGrade()->getName().'</td>
                <td>'.$class->getTeacher()->getFirstName().' '.$class->getTeacher()->getLastName().'</td>
                <td>'.$teachers[$i].'</td>
                <td>'.$subjects[$i].'</td>
                <td>
                 <a href="./classroom-form.php?id='.$class->getId().'" class="btn btn-primary btn-xs">Edit</a>
                </td>
            </tr>';
           $i++;
        }
        echo' 
            <div class="col-xs-12">
              <div class="card">
                <div class="card-header">
                  Classrooms
                </div>
                <div class="card-body no-padding">
                  <table class="datatable table table-striped primary" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Class name</th>
                            <th>Grade</th>
                            <th>Form teacher</th>
                            <th>Classroom teachers</th>
                            <th>Associated subjects</th>
                            <th> 
                            <a href="./classroom-form.php" 
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
    
    public static function classForm ($class, $forms=[], $teachers=[], $subjects=[], $errors = [], $success=false){
        $formOptions = "";
        $teacherOptions = "";
        $formTeacherOptions = "";
        $subjectOptions = "";
        $errorElement ="";
        $errorMsg ="";
        #populate option with forms in dropdown menu
        foreach($teachers as $teacher){
            if($class->getTeacher() != null){
                if($class->getTeacher()->getId() == $teacher->getId()){
                    $formTeacherOptions .='<option value="'.$teacher->getId().'" selected>'.$teacher->getFirstName().' '.$teacher->getLastName().'</option>'; 
                    continue;
                }
            }
            $formTeacherOptions .='<option value="'.$teacher->getId().'">'.$teacher->getFirstName().' '.$teacher->getLastName().'</option>';
        }
        
        #populate option with forms in dropdown menu
        foreach($forms as $form){
            if($class->getGrade() != null){
                if($class->getGrade()->getId() == $form->getId()){
                    $formOptions .='<option value="'.($form->getId().'" selected>'.$form->getName()).'</option>'; 
                    continue;
                }
            }
            $formOptions .='<option value="'.($form->getId().'">'.$form->getName()).'</option>';
        }
        
        #populate option with teachers in dropdown menu
        foreach($teachers as $teacher){
          $found= 0;
          if(count($class->getTeachers()) > 0){
               foreach($class->getTeachers() as $teach){
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
        
        #populate option with teachers in dropdown menu
        foreach($subjects as $subject){
          $found= 0;
          if(count($class->getSubjects()) > 0){
               foreach($class->getSubjects() as $sub){
                    if($sub->getId() == $subject->getId()){
                        $found = 1;
                        break;   
                    } 
               }
           }
           if($found){
               $subjectOptions .='<option value="'.$subject->getId().'" selected>'.$subject->getName().'</option>';
           }else{
               $subjectOptions .='<option value="'.$subject->getId().'">'.$subject->getName().'</option>';
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
                        action="../actions/classroom-actions.php"
                        method="post" 
                        class="form form-horizontal">
                    <input type="hidden" name="id" value="'.(($class->getId()!=null) ?$class->getId(): '').'" >
                    <div class="section">                       
                        <div class="section-body">
                            '.$errorElement.'
                            
                            '.(($success)?'
                            <div class="alert alert-success  alert-dismissible" role="alert" >
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                               Inserted Successfully
                            </div>':'').'

                        <div class="form-group">
                            <label class="col-md-3 control-label"> Class name</label>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                    <input type="text" 
                                       value="'.(($class->getName()!=null)?$class->getName():'').'"
                                       class="form-control"  
                                       name="name" 
                                       placeholder="Class name">
                               </div>                              
                             </div>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label class="col-md-3 control-label">Grade</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <select class="select2" name="form">
                                    '.$formOptions.'
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Select Form Teacher</label>
                            <div class="col-md-9">
                                <div class="col-md-6">
                                    <select class="select2" name="formTeacher">
                                    '.$formTeacherOptions.'
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Select class teacher(s) </label>
                            <div class="col-md-9">
                                <div class="col-md-12">
                                    <select class="select2" name="teachers[]" multiple>
                                    '.$teacherOptions.'
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Select class subject(s) </label>
                            <div class="col-md-9">
                                <div class="col-md-12">
                                    <select class="select2" name="subjects[]" multiple>
                                    '.$subjectOptions.'
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="form-footer">
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">'.(($class->getId()!=null)?'Save Changes':'Save').'</button>
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
