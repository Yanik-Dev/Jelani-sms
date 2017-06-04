<?php
require_once '../../models/Student.php';
require_once '../../services/StudentService.php';
require_once '../../common/Response.php';



$response = new Response();
if(isset($_POST['id']) && isset($_GET['action'])){
    $student = new Student();
    $student->setId($_POST['id']);
    if(StudentService::delete($student)){
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Student inserted successfully";
        echo json_encode($response);
        if(isset($_GET['ajax'])){
          header('Location: ../templates/login.php');
        }
        exit;
    };
}


$student = StudentService::getStudentFromPost($_POST);

if(isset($_POST['id'])){
    $student->setId($_POST['id']);
    if(StudentService::update($student)){
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Student inserted successfully";
        echo json_encode($response);
        if(isset($_GET['ajax'])){
          header('Location: ../templates/login.php');
        }
        exit;
    };
}

if(StudentService::insert($student)){
        $response->code = 200;
        $response->status = "Ok";
        $response->message = "Student inserted successfully";
        echo json_encode($response);
        if(isset($_GET['ajax'])){
          header('Location: ../templates/login.php');
        }
        exit;
 };
