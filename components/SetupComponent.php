<?php


class  SetupComponent{
    
    public static function dbSetup(){
        return '  <div class="form-suggestion">
                    Configure Database settings
                  </div>
                  <form action="../actions/setup-db-action.php" method="POST">
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">
                          <i class="fa fa-server" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="server" data-validation="required alphanumeric"  data-validation-allowing=":.-_" placeholder="Server" aria-describedby="basic-addon1">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2">
                          <i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" name="username"data-validation="required alphanumeric"  placeholder="Username" aria-describedby="basic-addon2">
                      </div>
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">
                          <i class="fa fa-key" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" name="password" data-validation="required alphanumeric" placeholder="Password" aria-describedby="basic-addon3">
                      </div>
                      <div class="text-center">
                          <input type="submit" name="submitBtn" class="btn btn-primary btn-submit" value="SAVE">   
                      </div>
                  </form>
              ';
    }
    
    public static function accountSetup($forms = []){
        $options = '';
        foreach($forms as $form){
            $options.='<option value="'.$form->getName().'">'.$form->getName().'</option>';
        }
        return '
          <div class="form-suggestion">
            Configure Database settings
          </div>
          <form action="../actions/setup-db-action.php?account=true" method="POST">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">
                  <i class="fa fa-building" aria-hidden="true"></i></span>
                <input type="text" 
                       class="form-control" 
                       name="schoolName" 
                       placeholder="School Name" 
                        data-validation="length required alphanumeric"
                        data-validation-allowing="- " 
                        data-validation-length="8-50"  
                       aria-describedby="basic-addon1">
              </div>
              <div class="form-group">
                <div class="form-suggestion">
                    Select the grades that are within the school
                </div>
                <select class="select2 form-control" data-validation="required" name="forms[]" multiple style="width:100%;">
                '.$options.'
                </select>
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon2">
                  <i class="fa fa-user" aria-hidden="true"></i></span>
                <input type="text" 
                        class="form-control" 
                        name="username" 
                        placeholder="Username" 
                        data-validation="length required alphanumeric"
                        data-validation-allowing="" 
                        data-validation-length="4-10"
                        aria-describedby="basic-addon2">
              </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon3">
                  <i class="fa fa-key" aria-hidden="true"></i></span>
                <input type="password" 
                      data-validation="length"
                      data-validation-length="min8" 
                      class="form-control" 
                      name="password" 
                      placeholder="Password" aria-describedby="basic-addon3">
                </div>
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon3">
                  <i class="fa fa-key" aria-hidden="true"></i></span>
                <input type="password" 
                       class="form-control"
                       name="confirmPassword" 
                       data-validation="confirmation" 
                       data-validation-confirm="password"
                       placeholder="Confirm Password" aria-describedby="basic-addon3">
              </div>
              <div class="text-center">
                  <input type="submit" class="btn btn-success btn-submit" value="Save">
              </div>
          </form>';
        
    }
}
