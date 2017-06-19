<?php
require_once '../models/Student.php';
require_once '../services/StudentService.php';
require_once '../common/Response.php';
require_once '../services/UploadService.php';
require_once '../config/Config.php';

global $_CONFIG;
$uploadService = new UploadService($_CONFIG["UPLOADDIR"]);
$response = new Response();

#deletes a student by the ID posted
if(isset($_GET['id']) && isset($_GET['action'])){
    $student = new Student();
    $student->setId($_GET['id']);
    $result = StudentService::delete($student);
    if($result["status"]){
        if(strcmp($result["path"], "") != 0) { $uploadService->removeFile($result["path"]); }
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Student deleted successfully";
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

#create a student object from the $_POST & $_FILE arrays
$student = StudentService::getStudentFromPost($_POST, $file["uploadedFile"]);

#updates a student's info
if(isset($_POST['id'])){
    if($_POST['id'] !=""){
        $student->setId($_POST['id']);
        if(StudentService::update($student)){
            $response->code = 200;
            $response->status = "Ok";
            $response->message = "Student updated successfully";
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

#check if student already exist
if(StudentService::exist($student)){
    $response->code = 409;
    $response->status = "Failed";
    $response->message = "Duplicate entry";
    echo json_encode($response);
    if(isset($_GET['ajax'])){
      header('Location: ../templates/login.php');
    }
    exit;
}

#creates a new student's record in the database
if(StudentService::insert($student)){
    $response->code = 200;
    $response->status = "Ok";
    $response->message = "Student inserted successfully";
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
