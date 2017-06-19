<?php
require_once '../models/Teacher.php';
require_once '../services/TeacherService.php';
require_once '../common/Response.php';
require_once '../services/UploadService.php';
require_once '../config/Config.php';

global $_CONFIG;
$uploadService = new UploadService($_CONFIG["UPLOADDIR"]);
$response = new Response();

#deletes a teacher by the ID posted
if(isset($_GET['id']) && isset($_GET['action'])){
    $teacher = new Teacher();
    $teacher->setId($_GET['id']);
    $result = TeacherService::delete($teacher);
    if($result["status"]){
        if(strcmp($result["path"], "") != 0) { $uploadService->removeFile($result["path"]); }
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Teacher deleted successfully";
        echo json_encode($response);
        if(isset($_GET['ajax'])){
          header('Location: ../templates/login.php');
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

#creates a teacher object from the $_POST & $_FILE arrays
$teacher = TeacherService::getFromPost($_POST, $file["uploadedFile"]);


#updates a teacher's info
if(isset($_POST['id'])){
    if($_POST['id'] !=""){
        $teacher->setId($_POST['id']);
        if(TeacherService::update($teacher)){
            $response->code = 200;
            $response->status = "Ok";
            $response->message = "Teacher updated successfully";
            echo json_encode($response);
            if(isset($_GET['ajax'])){
              header('Location: ../templates/login.php');
            }
            exit;
        }else{
            $response->code = 403;
            $response->status = "error";
            $response->message = "a server error has occured";
            $uploadService->removeFiles();
            echo json_encode($response);
            exit;
        }  
    }
}

#check if teacher already exist
if(TeacherService::exist($teacher)){
    $response->code = 409;
    $response->status = "Failed";
    $response->message = "Duplicate entry";
    echo json_encode($response);
    if(isset($_GET['ajax'])){
      header('Location: ../templates/login.php');
    }
    exit;
}

#creates a new teacher's record in the database
if(TeacherService::insert($teacher)){
    $response->code = 200;
    $response->status = "Ok";
    $response->message = "Teacher inserted successfully";
    echo json_encode($response);
    if(isset($_GET['ajax'])){
      header('Location: ../templates/login.php');
    }
    exit;
 }else{
    $response->code = 403;
    $response->status = "error";
    $response->message = "a server error has occured";
    $uploadService->removeFiles();
    echo json_encode($response);
 }
