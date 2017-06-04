<?php
require_once dirname(__FILE__).'/../models/Student.php';
require_once dirname(__FILE__).'/../models/Grade.php';

require_once dirname(__FILE__).'/../models/Classroom.php';
require_once dirname(__FILE__).'/../common/Security.php';
require_once dirname(__FILE__).'/../common/Database.php';

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
        if( $statement = @Database::getInstance()->prepare("INSERT INTO users SET role = ?, gender = ?, date_of_birth = ?, first_name = ?, "
                                                            . "last_name = ?, middle_name = ?, username = ?, "
                                                            . "password = ?, salt = ?, email = ?, address = ?, "
                                                            . "contact_no1 = ?, contact_no2 = ?, is_activated = 'yes'")){
            @$statement->bind_param("sssssssssssss",      
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
                die();
            }
            $fkUserId = $statement->insert_id;
            
            if( $statement = @Database::getInstance()->prepare("INSERT  INTO students SET id = ?, srn = ?, "
                                                                . " fk_academic_year_id = ?, fk_class_id = ?")){
                @$statement->bind_param("isii", 
                                           $fkUserId,                                                  
                                           $student->getSRN(),                                               
                                           $student->getAcademicYear(),                                     
                                           $student->getClass()->getClassId()
                                        );
                
                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    
                    Database::getInstance()->rollback();
                    die();
                
                }
                
                Database::getInstance()->commit();
                return true;

            }else{
            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
            var_dump(Database::getInstance());
                Database::getInstance()->rollback();

                die();
            
        }
        }else{
            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                Database::getInstance()->rollback();
                die();
            
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

            $statement->execute();

            if( $statement = @Database::getInstance()->prepare("UPDATE students SET srn = ?, "
                                                                . " fk_academic_year = ?, fk_class_id = ? WHERE id = ?")){
                $statement->bind_param("iiii",                                                 
                                           $student->getSRN(),                                               
                                           $student->getAcademicYear(),                                     
                                           $student->getClass()->getClassId(),
                                           $student->getId()
                );
                $statement->execute();
                
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
        if( $statement = @Database::getInstance()->prepare("DELETE FROM students WHERE id = ?")){
            $statement->bind_param("i", $student->getId());
            $statement->execute();
            return true;
        }
        return false;
    }
    
    public function getNextId(){
        $db = Database::getInstance();
        $result = $db->query('select id from albums order by id DESC LIMIT 0,1');
        $this->_count = $result->fetch_assoc()['id'];
        return (isset($this->_count))?$this->_count+1:1;
    }
    
    public static function setStudentPassword($student){
        $salt = Security::getSalt();
        $password = ($student->getSRN()!= null)?$student->getSRN():$student->getFirstName();
        $hash= Security::getHash($password, $salt);
        
        return ["salt"=> $salt, "hash"=>$hash];
    }
    
    public static function getStudentFromPost($postVar){
        
        $classroom = new Classroom();
        $classroom->setClassId($postVar['class']);

        $student = new Student();
        $student->setClass($classroom);
        $student->setAcademicYear(1);
        
        if(isset($postVar['srn'])){
            $student->setSRN($postVar['srn']);
        }
        $student->setFirstName($postVar['first_name']);
        $student->setLastName($postVar['last_name']);
        if(isset($postVar['middle_name'])){
            $student->setMiddleName($postVar['middle_name']);
        }
        
        $student->setGender($postVar['gender']); 
        $student->setDateOfBirth($postVar['date_of_birth']);
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
        $grade = new Grade($row['fk_form_id'], $row['form_name']);
        $classroom = new Classroom($row['fk_class_id'], $row['class_name'], $grade);
        $student = new Student();
        $student->setClass($classroom);
        $student->setPhoto($row['photo']);
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
}

