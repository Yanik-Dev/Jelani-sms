<?php

class  UserComponent{
    
    public static function userDatagrid($users, $title=''){
        $rows = "";
        foreach($users as $user){
           $rows .='  
            <tr>
                <td><img class="profile-img" style="width:50px; height:50px; border-radius: 50%;" src="'.(($user->getPhoto()!=null)?$user->getPhoto():'../assets/img/profile.png').'"></td>
                <td>'.ucfirst($user->getUsername()).'</td>
                <td>'.$user->getFirstName().' '.$user->getLastName().'</td> 
                <td>'.$user->getRole().'</td>
                <td>
                 <a href="./user-form.php?id='.$user->getId().'" class="btn btn-primary btn-xs">Edit</a>
                 <a href="../actions/user-actions.php?id='.$user->getId().'&action=delete" class="btn btn-danger btn-xs">Delete</a>
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
                            <th>Username</th>
                            <th>Name</th>
                            <th>Role</th>

                            <th> 
                              <a href="./user-form.php" 
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
    
    public static function userForm ($user, $errors = [], $success=false){
        $errorElement = "";
        $errorMsg ="";
        #get errors if any
        if(count($errors)>0){
            $i=0;
            foreach ($errors as $err){
              $errorMsg .=$err;
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
                        action="../actions/user-actions.php"
                        method="post" 
                        enctype="multipart/form-data"
                        class="form form-horizontal">
                    <div class="section">                       
                        <div class="section-body">
                            '.$errorElement.'
                            
                            '.(($success)?'
                            <div class="alert alert-success  alert-dismissible"  role="alert" >
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                               Inserted Successfully
                            </div>':'').'
                         <div class="form-group">
                            <input type="hidden" name ="id" value="'.(($user->getId()!=null)?$user->getId():'').'">
                             <input type="hidden" name ="role" value="'.(($user->getId()!=null)?$user->getRole():'Admin').'">
                            <div  class="col-md-3"> 
                                <label style="width:100%">Photo</label>
                                <img id="img-output"
                                    src="'.(($user->getPhoto()!=null)?$user->getPhoto():'../assets/img/profile.png').'" 
                                    class="img-circle" width="70px" height="70px">
                            </div>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                <input type="file"  data-validation="mime" 
                                    data-validation-allowing="jpg, png" 
                                    name="file" id="exampleInputFile" 
                                    onchange="previewImage(event)">
                                <p class="help-block">Select a photo to upload</p>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Username</label>
                            <div class="col-md-9">   
                                <div class="col-md-12">
                                    <input type="text" 
                                       value="'.(($user->getUsername()!=null)?$user->getUsername():'').'"
                                       class="form-control"  
                                       data-validation-length="0-11" 
                                       data-validation="length" 
                                       name="username" 
                                       placeholder="Username">
                               </div>                              
                             </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Password</label>
                            <div class="col-md-9">
                            <div class="col-md-6">
                               <input type="password" 
                                data-validation="length"
                                data-validation-length="min8" 
                                class="form-control" 
                                name="password" 
                                placeholder="Password" aria-describedby="basic-addon3">
                             </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirm Password</label>
                            <div class="col-md-9">
                            <div class="col-md-6">
                                <input type="password" 
                                       value=""
                                       class="form-control" 
                                       name="confirmPassword" 
                                       data-validation="confirmation" 
                                        data-validation-confirm="password"
                                        placeholder="Confirm Password"
                                       >
                             </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-footer">
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">'.(($user->getUsername()!=null)?'Save Changes':'Save').'</button>
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
