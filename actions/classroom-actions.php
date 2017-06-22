<?php
require_once '../models/Classroom.php';
require_once '../services/ClassroomService.php';
require_once '../common/Response.php';

$response = new Response();

#deletes a classroom by the ID posted
if(isset($_GET['id']) && isset($_GET['action'])){
    $classroom = new Classroom();
    $classroom->setId($_GET['id']);
    if(StudentService::delete($classroom)){
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Classroom deleted successfully";
        echo json_encode($response);
        if(isset($_GET['ajax'])){
          header('Location: ../templates/login.php');
        }
        exit;
    };
}

#create a classroom object from the $_POST & $_FILE arrays
$classroom = ClassroomService::getFromPost($_POST);

#updates a classroom's info
if(isset($_POST['id'])){
    if($_POST['id'] !=""){
        $classroom->setId($_POST['id']);
        if(ClassroomService::update($classroom)){
            $response->code = 200;
            $response->status = "Ok";
            $response->message = "Classroom updated successfully";
            echo json_encode($response);
            if(isset($_GET['ajax'])){
              header('Location: ../templates/login.php');
            }
            exit;
        }else{
            $response->code = 403;
            $response->status = "error";
            $response->message = "a server error has occured";
            echo json_encode($response);
            exit;
        } 
    }
}

#check if classroom already exist
if(ClassroomService::exist($classroom)){
    $response->code = 409;
    $response->status = "Failed";
    $response->message = "Duplicate entry";
    echo json_encode($response);
    if(isset($_GET['ajax'])){
      header('Location: ../templates/login.php');
    }
    exit;
}

#creates a new classroom's record in the database
if(ClassroomService::insert($classroom)){
    $response->code = 200;
    $response->status = "Ok";
    $response->message = "Classroom inserted successfully";
    echo json_encode($response);
    if(isset($_GET['ajax'])){
      header('Location: ../templates/login.php');
    }
    exit;
 }else{
    $response->code = 403;
    $response->status = "error";
    $response->message = "a server error has occured";
    echo json_encode($response);
 }
