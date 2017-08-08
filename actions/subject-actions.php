<?php
require_once '../models/Subject.php';
require_once '../services/SubjectService.php';
require_once '../common/Response.php';

$response = new Response();

#deletes a subject by the ID posted
if(isset($_GET['id']) && isset($_GET['action'])){
    $subject = new Subject();
    $subject->setId($_GET['id']);
    if(StudentService::delete($subject)){
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Subject deleted successfully";
        echo json_encode($response);
        if(isset($_GET['ajax'])){
          header('Location: ../templates/subject-view.php?code='.$response->code);
        }
        exit;
    };
}

#create a subject object from the $_POST & $_FILE arrays
$subject = SubjectService::getFromPost($_POST);

#updates a subject's info
if(isset($_POST['id'])){
    if($_POST['id'] !=""){
        $subject->setId($_POST['id']);
        if(SubjectService::update($subject)){
            $response->code = 200;
            $response->status = "Ok";
            $response->message = "Subject updated successfully";
            echo json_encode($response);
            if(!isset($_GET['ajax'])){
               header('Location: ../templates/subject-view.php?code='.$response->code);
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

#check if subject already exist
if(SubjectService::exist($subject)){
    $response->code = 409;
    $response->status = "Failed";
    $response->message = "Duplicate entry";
    echo json_encode($response);
    if(!isset($_GET['ajax'])){
       header('Location: ../templates/subject-view.php?code='.$response->code);
    }
    exit;
}

#creates a new subject's record in the database
if(SubjectService::insert($subject)){
    $response->code = 200;
    $response->status = "Ok";
    $response->message = "Subject inserted successfully";
    echo json_encode($response);
    if(!isset($_GET['ajax'])){
        header('Location: ../templates/subject-view.php?code='.$response->code);
    }
    exit;
 }else{
    $response->code = 403;
    $response->status = "error";
    $response->message = "a server error has occured";
    echo json_encode($response);
    header('Location: ../templates/subject-view.php?code='.$response->code);
    exit;
 }
