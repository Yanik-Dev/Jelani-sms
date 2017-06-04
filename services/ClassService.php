<?php
require_once dirname(__FILE__).'/../models/Grade.php';
require_once dirname(__FILE__).'/../models/Classroom.php';
require_once dirname(__FILE__).'/../common/Database.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClassService
 *
 * @author Yanik
 */
class ClassService {

    public static function insert($class){
        if( $statement = @Database::getInstance()->prepare("INSERT INTO classes SET name = ?, fk_form_id = ?")){
            @$statement->bind_param("si",$class->getName(),$class->getGrade()->getId());

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
           return true;

        }
    }  
    
    public static function update($student){
        if( $statement = @Database::getInstance()->prepare("UPDATE classes SET name = ?, fk_form_id = ?")){
            @$statement->bind_param("si",$class->getName(),$class->getGrade()->getId());

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
           return true;

        }
    }  
    
    public static function findOne($id){
        $class = new Classroom();
        if( $statement = @Database::getInstance()->prepare("SELECT forms.name as 'form_name', classes.* FROM classes "
                                                 . "INNER JOIN forms on forms.id = classes.fk_form_id WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $class = self::mapObjectFromArray($row);
                }
            }
        }

        return $class;
    }

    public static function findAll(){
        $classes = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT forms.name as 'form_name', classes.* FROM classes "
                                                 . "INNER JOIN forms on forms.id = classes.fk_form_id")){
             $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $class = self::mapObjectFromArray($row);
                    $classes[$i] = $class;
                    $i++;
                }
            }
        }
        return $classes;
    }

    public static function exist($student){
        if( $statement = @Database::getInstance()->prepare("SELECT forms.name as 'form_name', classes.* FROM classes "
                                                 . "INNER JOIN forms on forms.id = classes.fk_form_id WHERE name = ?")){
            @$statement->bind_param("s", $student->getSRN());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    return true;
                }
            }
        }

        return false;
    }   
    
    public static function findByGrade($grade_id){
        $classes = [];
        $i = 0;
         if( $statement = @Database::getInstance()->prepare("SELECT forms.name as 'form_name', classes.* FROM classes "
                                                 . "INNER JOIN forms on forms.id = classes.fk_form_id WHERE fk_form_id = ?")){
        $statement->bind_param("i", $grade_id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $class = self::mapObjectFromArray($row);
                    $classes[$i] = $class;
                    $i++;
                }
            }
        }

        return $classes;
    }
    
    public static function delete($student){
        if( $statement = @Database::getInstance()->prepare("DELETE FROM classes WHERE id = ?")){
            $statement->bind_param("i", $student->getId());
            $statement->execute();
            return true;
        }
        return false;
    }
   
    
    public static function getFromPost($postVar){
        $grade = new Grade();
        $grade->setId($postVar['grade']);
        $classroom = new Classroom();
        $classroom->setName($postVar['class']);
        $classroom->setId($postVar['id']);
        $classroom->setGrade($postVar['grade']);
        
        return $classroom;
    }
    
    public static function mapObjectFromArray($row){
        $grade = new Grade($row['fk_form_id'], $row['form_name']);
        $classroom = new Classroom($row['id'], $row['name'], $grade);
        
        return $classroom;
    }
}

