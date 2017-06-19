<?php
require_once dirname(__FILE__).'/../models/Grade.php';
require_once dirname(__FILE__).'/../models/Subject.php';
require_once dirname(__FILE__).'/../models/Classroom.php';
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
class ClassService {

    public static function insert($class){
        Database::getInstance()->autocommit(false);
        if( $statement = @Database::getInstance()->prepare("INSERT INTO classes SET name = ?, fk_teacher_id = ?, fk_form_id = ?")){
            @$statement->bind_param("sii",$class->getName(),$class->getTeacher()->getId(), $class->getGrade()->getId());

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
            
            $class_id = $statement->insert_id;
            $teachers = $class->getTeachers();
            $subjects = $class->getSubjects();
            foreach($teachers as $teacher){
                if( $statement = @Database::getInstance()->prepare("INSERT INTO teacher_classes SET fk_teacher_id = ?, fk_class_id = ?")){
                @$statement->bind_param("ii",$teacher->getId(),$class_id);

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        return false;
                        die();
                    }
                }
            }
            
            foreach($subjects as $subject){
                if( $statement = @Database::getInstance()->prepare("INSERT INTO class_subjects SET fk_subject_id = ?, fk_class_id = ?")){
                @$statement->bind_param("ii",$subject->getId(),$class_id);

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        return false;
                        die();
                    }
                }
            }
           @Database::getInstance()->commit(false);
           return true;

        }
    }  
    
    public static function update($class){
       Database::getInstance()->autocommit(false);
        if( $statement = @Database::getInstance()->prepare("UPDATE classes SET name = ?, fk_teacher_id = ?, fk_form_id = ?")){
            @$statement->bind_param("sii",$class->getName(),$class->getTeacher()->getId(), $class->getGrade()->getId());

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
                die();
            }
            
            if( $statement = @Database::getInstance()->prepare("DELETE teacher_classes WHERE fk_class_id = ?")){
                @$statement->bind_param("i", $class->getId());

                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                    die();
                }
            }
            
            if( $statement = @Database::getInstance()->prepare("DELETE class_subjects WHERE fk_class_id = ?")){
                @$statement->bind_param("i", $class->getId());

                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                    die();
                }
            }
            
            $teacher = $class->getTeachers();
            $subjects = $class->getSubjects();
            foreach($teachers as $teacher){
                if( $statement = @Database::getInstance()->prepare("INSERT INTO teacher_classes SET fk_teacher_id = ?, fk_class_id = ?")){
                @$statement->bind_param("ii",$teacher->getId(),$class->getId());

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        return false;
                        die();
                    }
                }
            }
            
            foreach($subjects as $subject){
                if( $statement = @Database::getInstance()->prepare("INSERT INTO class_subjects SET fk_subject_id = ?, fk_class_id = ?")){
                    @$statement->bind_param("ii",$subject->getId(),$class->getId());

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        return false;
                        die();
                    }
                }
            }
           @Database::getInstance()->commit(false);
        }
        
    }  
    
    public static function findOne($id){
        Database::getInstance()->autocommit(false);
        $class = new Classroom();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_classes WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $class = self::mapObjectFromArray($row);
                }
            }
            $subjects = [];
            $i=0;
             if( $statement = @Database::getInstance()->prepare("SELECT * FROM class_subjects INNER JOIN subjects"
                     . " ON subjects.subject_id = class_subjects.fk_subject_id   WHERE fk_class_id = ?")){
                @$statement->bind_param("i", $id);
                $statement->execute();
                if($rows = $statement->get_result()){
                    while($row = $rows->fetch_assoc()){
                        $subject = new Subject();
                        $subject->setId($row["subject_id"]);
                        $subject->setId($row["subject_code"]);
                        $subject->setId($row["subject_name"]);
                        $subjects[$i] = $subject;
                        $i++;
                    }
                    $class->setSubjects($subjects);
                }else{
                    echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                    Database::getInstance()->rollback();
                    die();
                }
            }else{
                echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                Database::getInstance()->rollback();
                die();
            }
            $i=0;
            if( $statement = @Database::getInstance()->prepare("SELECT * FROM teacher_classes INNER JOIN teachers"
                     . " ON  users.id = teacher_classes.fk_teacher_id   WHERE fk_class_id = ?")){
                @$statement->bind_param("i", $id);
                $statement->execute();
                if($rows = $statement->get_result()){
                    while($row = $rows->fetch_assoc()){
                        $teacher = new Teacher();
                        $teacher->setId($row["fk_teacher_id"]);
                        $teacher->setFirstName($row["first_name"]);
                        $teacher->setLastName($row["last_name"]);
                        $teachers[$i] = $teacher;
                        $i++;
                    }
                    $class->setTeachers($teachers);
                }else{
                    echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                    Database::getInstance()->rollback();
                    die();
                }
            }else{
                echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                Database::getInstance()->rollback();
                die();
            }
            Database::getInstance()->commit();
        }

        return $class;
    }

    public static function findAll(){
        $classes = [];
        $teachers = [];
        $subjects = [];
        $i = 0;
        
        Database::getInstance()->autocommit(false);
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_classes")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $class = new Classroom();
                    $class = self::mapObjectFromArray($row);
                 
                    $subjects = [];
                    $i=0;
                     if( $statement = @Database::getInstance()->prepare("SELECT * FROM class_subjects INNER JOIN subjects"
                             . " ON subjects.subject_id = class_subjects.fk_subject_id   WHERE fk_class_id = ?")){
                        @$statement->bind_param("i", $class->getId());
                        $statement->execute();
                        if($rows = $statement->get_result()){
                            while($row = $rows->fetch_assoc()){
                                $subject = new Subject();
                                $subject->setId($row["subject_id"]);
                                $subject->setId($row["subject_code"]);
                                $subject->setId($row["subject_name"]);
                                $subjects[$i] = $subject;
                                $i++;
                            }
                            $class->setSubjects($subjects);
                        }else{
                            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                            Database::getInstance()->rollback();
                            die();
                        }
                    }else{
                        echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                        Database::getInstance()->rollback();
                        die();
                    }
                    $i=0;
                    if( $statement = @Database::getInstance()->prepare("SELECT * FROM teacher_classes INNER JOIN users"
                             . " ON  users.id = teacher_classes.fk_teacher_id   WHERE fk_class_id = ?")){
                        @$statement->bind_param("i", $class->getId());
                        $statement->execute();
                        if($rows = $statement->get_result()){
                            while($row = $rows->fetch_assoc()){
                                $teacher = new Teacher();
                                $teacher->setId($row["fk_teacher_id"]);
                                $teacher->setFirstName($row["first_name"]);
                                $teacher->setLastName($row["last_name"]);
                                $teachers[$i] = $teacher;
                                $i++;
                            }
                            $class->setTeachers($teachers);
                    }else{
                        echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                        Database::getInstance()->rollback();
                        die();
                    }
                    }else{
                        echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                        Database::getInstance()->rollback();
                        die();
                    }
                    $classes[$i] = $class;
                    $i++;
                }
            }
            Database::getInstance()->commit();
        }

        return  $classes;
    }

    public static function exist($class){
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_classes WHERE name = ? and fk_form_id = ?")){
            @$statement->bind_param("ss", $class->getName(), $class->getGrade()->getId());
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
        $teachers = [];
        $subjects = [];
        $i = 0;
        
        Database::getInstance()->autocommit(false);
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_classes where fk_form_id = ?")){
            @$statement->bind_param("i", $grade_id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $class = new Classroom();
                    $class = self::mapObjectFromArray($row);
                 
                    $subjects = [];
                    $i=0;
                     if( $statement = @Database::getInstance()->prepare("SELECT * FROM class_subjects INNER JOIN subjects"
                             . " ON subjects.subject_id = class_subjects.fk_subject_id   WHERE fk_class_id = ?")){
                        @$statement->bind_param("i", $class->getId());
                        $statement->execute();
                        if($rows = $statement->get_result()){
                            while($row = $rows->fetch_assoc()){
                                $subject = new Subject();
                                $subject->setId($row["subject_id"]);
                                $subject->setId($row["subject_code"]);
                                $subject->setId($row["subject_name"]);
                                $subjects[$i] = $subject;
                                $i++;
                            }
                            $class->setSubjects($subjects);
                        }else{
                            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                            Database::getInstance()->rollback();
                            die();
                        }
                    }else{
                        echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                        Database::getInstance()->rollback();
                        die();
                    }
                    $i=0;
                    if( $statement = @Database::getInstance()->prepare("SELECT * FROM teacher_classes INNER JOIN users"
                             . " ON  users.id = teacher_classes.fk_teacher_id   WHERE fk_class_id = ?")){
                        @$statement->bind_param("i", $class->getId());
                        $statement->execute();
                        if($rows = $statement->get_result()){
                            while($row = $rows->fetch_assoc()){
                                $teacher = new Teacher();
                                $teacher->setId($row["fk_teacher_id"]);
                                $teacher->setFirstName($row["first_name"]);
                                $teacher->setLastName($row["last_name"]);
                                $teachers[$i] = $teacher;
                                $i++;
                            }
                            $class->setTeachers($teachers);
                        }else{
                            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                            Database::getInstance()->rollback();
                            die();
                        }
                    }else{
                        echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                        Database::getInstance()->rollback();
                        die();
                    }
                    $classes[$i] = $class;
                    $i++;
                }
            }
            Database::getInstance()->commit();
        }

        return  $classes;
    }
    
    public static function delete($class){
        if( $statement = @Database::getInstance()->prepare("DELETE FROM classes WHERE id = ?")){
            $statement->bind_param("i", $class->getId());
            $statement->execute();
            return true;
        }
        return false;
    }
   
    
    public static function getFromPost($postVar){
        $classroom = new Classroom();
        $grade = new Grade();
        $teacher = new Teacher();
        $subjects = [];
        $teachers = [];
        
        $teacherArr = $postVar['teachers'];
        $subjectArr =$postVar['subjects'];
        $i=0;
        foreach($teacherArr as $teach){
            $t = new Teacher();
            $t->setId($teach);
            $teachers[$i] = $t;
            $i++;
        }
        $i=0;
        foreach($subjects as $sub){
            $s = new Subject();
            $s->setId($sub);
            $subjects[$i] = $s;
            $i++;
        }
        $teacher->setId($postVar['formTeacher']);
        $grade->setId($postVar['grade']);
        
        $classroom->setName($postVar['class']);
        $classroom->setId($postVar['id']);
        $classroom->setGrade($postVar['grade']);
        $classroom->setTeachers($teachers);
        $classroom->setSubjects($subjects);
        
        return $classroom;
    }
    
    public static function mapObjectFromArray($row){
        $grade = new Grade($row['fk_form_id'], $row['form_name']);
        $classroom = new Classroom($row['id'], $row['name'], $grade);
        $teacher = new Teacher();
        $teacher->setId($row["fk_teacher_id"]);
        /*$teacher->setFirstName($row["first_name"]);
        $teacher->setLastName($row["last_name"]);*/
        $classroom->setTeacher($teacher);
        
        return $classroom;
    }
}

