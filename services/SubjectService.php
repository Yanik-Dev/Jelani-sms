<?php
require_once dirname(__FILE__).'/../models/Subject.php';
require_once dirname(__FILE__).'/../models/Teacher.php';
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
class SubjectService {

    public static function insert($subject){
        Database::getInstance()->autocommit(false);
        if( $statement = @Database::getInstance()->prepare("INSERT INTO subjects SET subject_name = ?, subject_code = ?")){
            @$statement->bind_param("ss",$subject->getName(),$subject->getCode());

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
            
            $subject_id = $statement->insert_id;
            $teachers = $subject->getTeachers();
            foreach($teachers as $teacher){
                if( $statement = @Database::getInstance()->prepare("INSERT INTO teacher_subjects SET fk_teacher_id = ?, fk_subject_id = ?")){
                @$statement->bind_param("ii",$teacher->getId(),$subject_id);

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        return false;
                        die();
                    }
                }else {
                        echo "Execute failed: (" . @Database::getInstance()->errno . ") " . @Database::getInstance()->error;
                        Database::getInstance()->rollback();
                        return false;
                        die();
                    }
            }
            Database::getInstance()->commit();
            return true;

        }
    }  
    
    public static function update($subject){
        Database::getInstance()->autocommit(false);
        if( $statement = @Database::getInstance()->prepare("UPDATE subjects SET subject_name = ?, subject_code = ? WHERE subject_id = ?")){
            @$statement->bind_param("ssi",$subject->getName(),$subject->getCode(),$subject->getId());
            
            
            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
            if( $statement = @Database::getInstance()->prepare("DELETE FROM teacher_subjects WHERE fk_subject_id = ?")){
                @$statement->bind_param("i", $subject->getId());

                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                }
            }
            $teachers = $subject->getTeachers();
            foreach($teachers as $teacher){
                if( $statement = @Database::getInstance()->prepare("INSERT INTO teacher_subjects SET fk_teacher_id = ?, fk_subject_id = ?")){
                @$statement->bind_param("ii",$teacher->getId(),$subject->getId());

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        return false;
                    }
                }
            }
            @Database::getInstance()->commit(false);
            return true;

        } 
    }  
    
    public static function findOne($id){
        $subject = new Subject();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM subjects WHERE subject_id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $subject = self::mapObjectFromArray($row);
                }
                $teachers = [];
                $i=0;
                if( $statement = @Database::getInstance()->prepare("SELECT * FROM teacher_subjects INNER JOIN users"
                         . " ON  users.id = teacher_subjects.fk_teacher_id   WHERE fk_subject_id = ?")){
                    @$statement->bind_param("i", $id);
                    $statement->execute();
                    if($teachRows = $statement->get_result()){
                        while($row = $teachRows->fetch_assoc()){
                            $teacher = new Teacher();
                            $teacher->setId($row["fk_teacher_id"]);
                            $teacher->setFirstName($row["first_name"]);
                            $teacher->setLastName($row["last_name"]);
                            $teachers[$i] = $teacher;
                            $i++;
                        }
                        $subject->setTeachers($teachers);
                    }else{
                                echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                                die();
                     }
                }else{
                    echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                    die();
                }
            }
        }
        
        return $subject;
    }

    public static function findAll(){
        $teachers = [];
        $subjects = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM subjects")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $subject = new Subject();
                    $subject = self::mapObjectFromArray($row);
                    
                    if( $statement = @Database::getInstance()->prepare("SELECT * FROM teacher_subjects INNER JOIN users"
                             . " ON  users.id = teacher_subjects.fk_teacher_id   WHERE fk_subject_id = ?")){
                        @$statement->bind_param("i", $subject->getId());
                        $statement->execute();
                        if($teachRows = $statement->get_result()){
                            while($row = $teachRows->fetch_assoc()){
                                $teacher = new Teacher();
                                $teacher->setId($row["fk_teacher_id"]);
                                $teacher->setFirstName($row["first_name"]);
                                $teacher->setLastName($row["last_name"]);
                                $teachers[$i] = $teacher;
                                $i++;
                            }
                            $i=0;
                            $subject->setTeachers($teachers);
                        }else{
                            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                            die();
                        }
                    }
                    $subjects[$i] = $subject;
                    $i++;
                }
            }
        }

        return  $subjects;
    }

    public static function exist($subject){
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM subjects WHERE subject_name = ? or subject_code = ? ")){
            @$statement->bind_param("ss", $subject->getName(),$subject->getCode());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    return true;
                }
            }
        }
        return false;
    }   
    
    
    
    public static function delete($subject){
        if( $statement = @Database::getInstance()->prepare("DELETE FROM subjects WHERE subject_id = ?")){
            $statement->bind_param("i", $subject->getId());
            $statement->execute();
            return true;
        }
        return false;
    }
   
    
    public static function getFromPost($postVar){
        $subject = new Subject();
        $subject->setCode($postVar['code']);        
        $subject->setName($postVar['name']);
        if(isset($postVar['id'])){
         $subject->setId($postVar['id']);
        }
        $teachers = [];
        $teacherArr = $postVar['teachers'];
        $i=0;
        foreach($teacherArr as $teach){
            $t = new Teacher();
            $t->setId($teach);
            $teachers[$i] = $t;
            $i++;
        }
        $subject->setTeachers($teachers);
        
        return $subject;
    }
    
    public static function mapObjectFromArray($row){
        $subject = new Subject();
        $subject->setId($row["subject_id"]);
        $subject->setCode($row["subject_code"]);
        $subject->setName($row["subject_name"]);
        
        return $subject;
    }
}

