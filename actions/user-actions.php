<?php
require_once '../models/User.php';
require_once '../services/UserService.php';
require_once '../common/Response.php';
require_once '../services/UploadService.php';
require_once '../config/Config.php';

global $_CONFIG;
$uploadService = new UploadService($_CONFIG["UPLOADDIR"]);
$response = new Response();

#deletes a user by the ID posted
if(isset($_GET['id']) && isset($_GET['action'])){
    $user = new User();
    $user->setId($_GET['id']);
    $users = UserService::findAll();
    $count = 0;
    foreach($users as $user){
        if($user->getRole() == "Admin"){
            $count++;
        }
    }
    
    if($count == 1){
        $response->code = 41;
        $response->status = "Denied";
        $response->message = "Cannot delete";
        header('Location: ../templates/user-view.php?code='.$response->code);
        exit;
    }
    $result = UserService::delete($user);
   
    if($result["status"]){
        if(strcmp($result["path"], "") != 0) { $uploadService->removeFile($result["path"]); }
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "user deleted successfully";
        echo json_encode($response);
        if(!isset($_GET['ajax'])){
          header('Location: ../templates/user-view.php?code='.$response->code);
        }
        exit;
    };
}

#checks if a file is posted thens uploads it
if(strcmp($_FILES['file']['name'], "") != 0){
   $result = $uploadService->uploadSingleFile($_FILES['file']);
}

#get upload results
$file = (isset($result))? $result: ["status"=>"ok", "uploadedFile"=>""];

#create a user object from the $_POST & $_FILE arrays
$user = UserService::getUserFromPost($_POST, $file["uploadedFile"]);

#updates a user's info
if(isset($_POST['id'])){
    if($_POST['id'] !=""){
        $user->setId($_POST['id']);
        if(UserService::update($user)){
            $response->code = 200;
            $response->status = "Ok";
            $response->message = "user updated successfully";
            echo json_encode($response);
            if(!isset($_GET['ajax'])){
              header('Location: ../templates/user-form.php?code='.$response->code);
            }
            exit;
        }else{
            $response->code = 403;
            $response->status = "error";
            $response->message = "a server error has occured";
            $uploadService->removeFiles();
            echo json_encode($response);
            header('Location: ../templates/user-form.php?code='.$response->code);
            exit;
        }  
    }
}

#check if user already exist
if(UserService::exist($user)){
    $response->code = 409;
    $response->status = "Failed";
    $response->message = "Duplicate entry";
    echo json_encode($response);
    if(!isset($_GET['ajax'])){
      header('Location: ../templates/user-form.php?code='.$response->code);
    }
    exit;
}

#creates a new user's record in the database
if(UserService::insert($user)){
    $response->code = 200;
    $response->status = "Ok";
    $response->message = "user inserted successfully";
    echo json_encode($response);
    if(!isset($_GET['ajax'])){
      header('Location: ../templates/user-form.php?code='.$response->code);
    }
    exit;
 }else{
    $response->code = 403;
    $response->status = "error";
    $response->message = "a server error has occured";
    $uploadService->removeFiles();
    echo json_encode($response);
    header('Location: ../templates/user-form.php?code='.$response->code);
 }
