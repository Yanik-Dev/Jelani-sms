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
 * Description of GradeService
 *
 * @author Yanik
 */
class GradeService {

    public static function insert($form){
        if( $statement = @Database::getInstance()->prepare("INSERT INTO forms SET name = ?")){
            @$statement->bind_param("s",$form->getName());

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
           return true;

        }
    }  
    
    public static function update($form){
        if( $statement = @Database::getInstance()->prepare("UPDATE forms SET name = ?")){
            @$statement->bind_param("si",$form->getName());

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
        $form = new Classroom();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM forms")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $form = self::mapObjectFromArray($row);
                }
            }
        }

        return $form;
    }

    public static function findAll(){
        $forms = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * from forms")){
             $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $form = self::mapObjectFromArray($row);
                    $forms[$i] = $form;
                    $i++;
                }
            }
        }
        return $forms;
    }
    
    public static function findAllAvailableForms(){
        $forms = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * from available_forms")){
             $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $form = self::mapObjectFromArray($row);
                    $forms[$i] = $form;
                    $i++;
                }
            }
        }
        return $forms;
    }
    

    
    public static function delete($form){
        if( $statement = @Database::getInstance()->prepare("DELETE FROM classes WHERE id = ?")){
            $statement->bind_param("i", $form->getId());
            $statement->execute();
            return true;
        }
        return false;
    }
   
    
    public static function mapObjectFromArray($row){
        $grade = new Grade($row['id'], $row['name']);
        
        return $grade;
    }
}

