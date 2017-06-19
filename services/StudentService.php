<?php
require_once dirname(__FILE__).'/../models/Student.php';
require_once dirname(__FILE__).'/../models/Grade.php';
require_once dirname(__FILE__).'/../models/Classroom.php';
require_once dirname(__FILE__).'/../common/Security.php';
require_once dirname(__FILE__).'/../common/Database.php';
require_once dirname(__FILE__).'/../config/Config.php';


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Student
 *
 * @author Yanik
 */
class StudentService {

    public static function insert($student){
        Database::getInstance()->autocommit (false);
        if( $statement = @Database::getInstance()->prepare("INSERT INTO users SET photo= ?, role = ?, gender = ?, date_of_birth = ?, first_name = ?, "
                                                            . "last_name = ?, middle_name = ?, username = ?, "
                                                            . "password = ?, salt = ?, email = ?, address = ?, "
                                                            . "contact_no1 = ?, contact_no2 = ?, is_activated = 'yes'")){
            @$statement->bind_param("ssssssssssssss",      
                                    $student->getPhoto(),
                                    $student->getRole(),   
                                    $student->getGender(),                                    
                                    $student->getDateOfBirth(),                                        
                                    $student->getFirstName(),                                        
                                    $student->getLastName(),                                        
                                    $student->getMiddleName(), 
                                    $student->getUsername(),
                                    $student->getPassword(),
                                    $student->getSalt(),
                                    $student->getEmail(),                          
                                    $student->getAddress(),                          
                                    $student->getContactNo1(),                       
                                    $student->getContactNo2()
                                   );

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
            }
            $fkUserId = $statement->insert_id;
            
            if( $statement = @Database::getInstance()->prepare("INSERT  INTO students SET id = ?, srn = ?, "
                                                                . " fk_academic_year_id = ?, fk_class_id = ?")){
                @$statement->bind_param("isii", 
                                           $fkUserId,                                                  
                                           $student->getSRN(),                                               
                                           $student->getAcademicYear(),                                     
                                           $student->getClass()->getId()
                                        );
                
                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                }
                
                Database::getInstance()->commit();
                return true;

            }else{
                echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                Database::getInstance()->rollback();
                return false;
            }
        }else{
            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
            Database::getInstance()->rollback();
            return false;
        }
        
        Database::getInstance()->rollback();
      
        return false;
    }  
    
    public static function update($student){
        Database::getInstance()->autocommit (false);
        if( $statement = @Database::getInstance()->prepare("UPDATE users SET photo = ?, role = ?, gender = ?, date_of_birth = ?, first_name = ?, "
                                                            . "last_name = ?, middle_name = ?, username = ?, "
                                                            . "password = ?, salt = ?, email = ?, address = ?, "
                                                            . "contact_no1 = ?, contact_no2 = ? WHERE id = ?")){
            @$statement->bind_param("ssssssssssssssi",                                
                                            $student->getPhoto(),  
                                            $student->getRole(),                                       
                                            $student->getGender(),                                    
                                            $student->getDateOfBirth(),                                        
                                            $student->getFirstName(),                                        
                                            $student->getLastName(),                                        
                                            $student->getMiddleName(), 
                                            $student->getUsername(),
                                            $student->getPassword(),
                                            $student->getSalt(),
                                            $student->getEmail(),                          
                                            $student->getAddress(),                          
                                            $student->getContactNo1(),                       
                                            $student->getContactNo2(),
                                            $student->getId()
                                           );

             if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                }

            if( $statement = @Database::getInstance()->prepare("UPDATE students SET srn = ?, "
                                                                . " fk_academic_year_id = ?, fk_class_id = ? WHERE id = ?")){
                @$statement->bind_param("iiii",                                                 
                                           $student->getSRN(),                                               
                                           $student->getAcademicYear(),                                     
                                           $student->getClass()->getId(),
                                           $student->getId()
                );
                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                }
                
                Database::getInstance()->commit();
                return true;

            }
        }
        
        Database::getInstance()->rollback();
      
        return false;
    }  
    
    public static function findOne($id){
        $student = new Student();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_students WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $student = self::mapObjectFromArray($row);
                }
            }
        }

        return $student;
    }

    public static function findAll(){
        $students = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_students")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $student = self::mapObjectFromArray($row);
                    $students[$i] = $student;
                    $i++;
                }
            }
        }
        return $students;
    }

    public static function exist($student){
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_students WHERE srn = ? ")){
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
        $students = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_students WHERE grade_id = ?")){
            $statement->bind_param("i", $grade_id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $student = self::mapObjectFromArray($row);
                    $students[$i] = $student;
                    $i++;
                }
            }
        }

        return $students;
    }
    
    public static function delete($student){
        $path = "";
        if($statement = @Database::getInstance()->prepare("SELECT photo FROM users WHERE id = ?")){
            @$statement->bind_param("i", $student->getId());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $path = $row["photo"];
                }
            }
            if( $statement = @Database::getInstance()->prepare("DELETE FROM users WHERE id = ?")){
                @$statement->bind_param("i", $student->getId());
                $statement->execute();
                return ["status"=> true, "path"=>$path];
            }
        }
        return ["status" => false];
    }
    
    
    public static function setStudentPassword($student){
        $salt = Security::getSalt();
        $password = ($student->getSRN()!= null)?$student->getSRN():$student->getFirstName();
        $hash= Security::getHash($password, $salt);
        
        return ["salt"=> $salt, "hash"=>$hash];
    }
    
    public static function getStudentFromPost($postVar, $filename=''){
        
        $classroom = new Classroom();
        $classroom->setId($postVar['class']);

        $student = new Student();
        $student->setClass($classroom);
        $student->setAcademicYear(1);
        
        if(strcmp('', $filename)!= 0){
            $student->setPhoto($filename);
        }
        
        if(isset($postVar['srn'])){
            $student->setSRN($postVar['srn']);
        }
        $student->setFirstName($postVar['first_name']);
        $student->setLastName($postVar['last_name']);
        
        if(isset($postVar['middle_name'])){
            $student->setMiddleName($postVar['middle_name']);
        }
        
        $student->setGender($postVar['gender']); 
        $student->setDateOfBirth(date("Y-m-d", strtotime($postVar['date_of_birth'])));
        $student->setRole("Student");
        
        if(isset($postVar['email'])){
            $student->setEmail($postVar['email']);
        }
        if(isset($postVar['address'])){
            $student->setAddress($postVar['address']);
        }
        if(isset($postVar['contact_no1'])){
            $student->setContactNo1($postVar['contact_no1']); 
        }
        if(isset($postVar['contact_no2'])){
            $student->setContactNo2($postVar['contact_no2']);
        }
        $pass = self::setStudentPassword($student);
        $student->setPassword($pass['hash']);
        $student->setSalt($pass['salt']);
        $student->setUsername($student->getFirstName());

        return $student;
    }
    
    public static function mapObjectFromArray($row){
        global $_CONFIG;
        $grade = new Grade($row['fk_form_id'], $row['form_name']);
        $classroom = new Classroom($row['fk_class_id'], $row['class_name'], $grade);
        $student = new Student();
        $student->setClass($classroom);
        $student->setPhoto((isset($row['photo']))?$_CONFIG["UPLOADDIR"].$row['photo']:null);
        $student->setSRN($row['srn']);
        $student->setId($row['id']);
        $student->setFirstName($row['first_name']);
        $student->setLastName($row['last_name']);
        $student->setMiddleName($row['middle_name']);
        $student->setGender($row['gender']); 
        $student->setDateOfBirth($row['date_of_birth']);
        $student->setUsername($row['username']);
        $student->setPassword($row['password']);
        $student->setSalt($row['salt']);
        $student->setRole($row['role']);
        $student->setEmail($row['email']);
        $student->setAcademicYear($row['year']);
        $student->setAddress($row['address']);
        $student->setContactNo1($row['contact_no1']);    
        $student->setContactNo2($row['contact_no2']);
        return $student;
    }
    
    public static function validateInputs($input){
        
        if(filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
            
        }
        if(strcmp(trim($input['first_name'],"") == 0)){
            
        }
        if(strcmp(trim($input['last_name'],"") == 0)){
            
        }
        if(isset($input['gender'])){
            
        }
        if(strcmp(trim($input['gender']),"Male") != 0 || strcmp(trim($input['gender']),"Female") != 0){
                
        }
        if(isset($input['contact_no1'])){
            
        }
        if(isset($input['date_of_birth'])){
            
        }
        if(isset($input['class'])){
            
        }
        
        
    }
}

