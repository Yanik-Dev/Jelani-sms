<?php
require_once dirname(__FILE__).'/../models/Student.php';
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
class GuardianService {

    public static function insert($guardian){
        Database::getInstance()->autocommit (false);
        if( $statement = @Database::getInstance()->prepare("INSERT INTO users SET role = ?, gender = ?, first_name = ?, "
                                                            . "username = ?, password = ?, salt = ?, email = ?, "
                                                            . "contact_no1 = ?, contact_no2 = ?, is_activated = 'yes'")){
            @$statement->bind_param("sssssssss",      
                                    $guardian->getRole(),                                       
                                    $guardian->getGender(),                                             
                                    $guardian->getFirstName(),    
                                    $guardian->getUsername(),
                                    $guardian->getPassword(),
                                    $guardian->getSalt(),
                                    $guardian->getEmail(),                            
                                    $guardian->getContactNo1(),                       
                                    $guardian->getContactNo2()
                                   );

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                die();
            }
            $fkUserId = $statement->insert_id;
            
            if( $statement = @Database::getInstance()->prepare("INSERT  INTO guardians SET id = ?, fk_student_id = ?, "
                                                                . " type = ?, profession = ?")){
                @$statement->bind_param("iiss", 
                                           $fkUserId,                                                  
                                           $guardian->getStudent()->getId,                                               
                                           $guardian->getType(),                                     
                                           $guardian->getProfession()
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
    
    public static function update($guardian){
     
    }  
    
    public static function findOne($id){
        $guardian = new Guardian();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_guardians WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $guardian = mapObjectFromArray($row);
                }
            }
        }

        return $guardian;
    }
    
    public static function exist($guardian){
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_guardians WHERE first_name = ? AND fk_student_id = ?")){
            @$statement->bind_param("si", $guardian->getFirstName(), $guardian->getChild()->getId());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    return true;
                }
            }
        }

        return false;
    }

    public static function findAll(){
        $guardians = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_guardians")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $guardian = mapObjectFromArray($row);
                    $guardians[$i] = $guardian;
                    $i++;
                }
            }
        }

        return $guardians;
    }

    
    public static function findByStudent($student_id){
        $guardians = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_guardians WHERE fk_student_id = ?")){
            $statement->bind_param("i", $student_id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $guardian = mapObjectFromArray($row);
                    $guardians[$i] = $guardian;
                    $i++;
                }
            }
        }

        return $guardians;
    }
    
    public static function delete($guardian){
        if( $statement = @Database::getInstance()->prepare("DELETE FROM students WHERE id = ?")){
            $statement->bind_param("i", $guardian->getId());
            $statement->execute();
            return true;
        }
        return false;
    }
    

    
    public static function setPassword($guardian){
        $salt = Security::getSalt();
        $password = $guardian->getContactNo1();
        $hash= Security::getHash($password, $salt);
        
        return ["salt"=> $salt, "hash"=>$hash];
    }
    
    public static function getStudentFromPost($postVar){
        
        $student = new Student();
        $student->setId($postVar['student']);

        $guardian = new Guardian();
        $guardian->setChild($student);
        $guardian->setFirstName($postVar['first_name']);
        $guardian->setType($postVar['type']);
        $guardian->setProfession($postVar['profession']);

        $guardian->setGender($postVar['gender']); 
        $guardian->setRole("Guardian");
        if(isset($postVar['email'])){
            $guardian->setEmail($postVar['email']);
        }
        if(isset($postVar['contact_no1'])){
            $guardian->setContactNo1($postVar['contact_no1']); 
        }
        if(isset($postVar['contact_no2'])){
            $guardian->setContactNo2($postVar['contact_no2']);
        }
        $pass = self::setPassword($guardian);
        $guardian->setPassword($pass['hash']);
        $guardian->setSalt($pass['salt']);
        $guardian->setUsername($guardian->getFirstName().$postVar['student']);


        return $guardian;
    }
    
    public function mapObjectFromArray($row){
        $student = new Student();
        $guardian = new Guardian();
        
        $student->setId($row['fk_student_id']);
        $guardian->getChild($student);
        $guardian->setId($row['id']);       
        $guardian->setId($row['type']);
        $guardian->setId($row['profession']);
        $guardian->setFirstName($row['first_name']);
        $guardian->setGender($row['gender']); 
        $guardian->setUsername($row['username']);
        $guardian->setPassword($row['password']);
        $guardian->setSalt($row['salt']);
        $guardian->setRole($row['role']);
        $guardian->setEmail($row['email']);
        $guardian->setContactNo1($row['contact_no1']);    
        $guardian->setContactNo2($row['contact_no2']);
        return $guardian;
    }
}

