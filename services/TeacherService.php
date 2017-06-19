<?php
require_once dirname(__FILE__).'/../models/Teacher.php';
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
class TeacherService {

    public static function insert($teacher){
        Database::getInstance()->autocommit (false);
        if( $statement = @Database::getInstance()->prepare("INSERT INTO users SET photo= ?, role = ?, gender = ?, first_name = ?, "
                                                            . "last_name = ?, middle_name = ?, username = ?, "
                                                            . "password = ?, salt = ?, email = ?, address = ?, "
                                                            . "contact_no1 = ?, contact_no2 = ?, trn = ?, is_activated = 'yes'")){
            @$statement->bind_param("ssssssssssssss",      
                                    $teacher->getPhoto(),
                                    $teacher->getRole(),   
                                    $teacher->getGender(),                                                  
                                    $teacher->getFirstName(),                                        
                                    $teacher->getLastName(),                                        
                                    $teacher->getMiddleName(), 
                                    $teacher->getUsername(),
                                    $teacher->getPassword(),
                                    $teacher->getSalt(),
                                    $teacher->getEmail(),                          
                                    $teacher->getAddress(),                          
                                    $teacher->getContactNo1(),                       
                                    $teacher->getContactNo2(),                                           
                                    $teacher->getTRN()
                        
                                   );

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                return false;
            }
            $fkUserId = $statement->insert_id;
            
            if( $statement = @Database::getInstance()->prepare("INSERT  INTO teachers SET teacher_id = ?,  "
                                                                . " date_of_employment = ?, marital_status = ?")){
                @$statement->bind_param("iss", 
                                           $fkUserId,                  
                                           $teacher->getDateOfEmployment(),
                                           $teacher->getMaritalStatus()
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
    
    public static function update($teacher){
        Database::getInstance()->autocommit (false);
        if( $statement = @Database::getInstance()->prepare("UPDATE users SET photo = ?, role = ?, gender = ?, first_name = ?, "
                                                            . "last_name = ?, middle_name = ?, username = ?, "
                                                            . "password = ?, salt = ?, email = ?, address = ?, "
                                                            . "contact_no1 = ?, contact_no2 = ?, trn = ? WHERE id = ?")){
            @$statement->bind_param("ssssssssssssssi",                                
                                            $teacher->getPhoto(),  
                                            $teacher->getRole(),                                       
                                            $teacher->getGender(),                                             
                                            $teacher->getFirstName(),                                        
                                            $teacher->getLastName(),                                        
                                            $teacher->getMiddleName(), 
                                            $teacher->getUsername(),
                                            $teacher->getPassword(),
                                            $teacher->getSalt(),
                                            $teacher->getEmail(),                          
                                            $teacher->getAddress(),                          
                                            $teacher->getContactNo1(),                       
                                            $teacher->getContactNo2(),                                   
                                            $teacher->getTRN(), 
                                            $teacher->getId()
                                           );

             if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    return false;
                }

            if( $statement = @Database::getInstance()->prepare("UPDATE teachers SET  "
                                                                . " date_of_employment = ?, marital_status = ? WHERE teacher_id = ?")){
                @$statement->bind_param("ssi",                       
                                           $teacher->getDateOfEmployment(),
                                           $teacher->getMaritalStatus(),
                                           $teacher->getId()
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
        $teacher = new Teacher();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_teachers WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $teacher = self::mapObjectFromArray($row);
                }
            }
        }

        return $teacher;
    }

    public static function findAll(){
        $teachers = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_teachers")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $teacher = self::mapObjectFromArray($row);
                    $teachers[$i] = $teacher;
                    $i++;
                }
            }
        }
        return $teachers;
    }

    public static function exist($teacher){
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM v_teachers WHERE trn = ? ")){
            @$statement->bind_param("s", $teacher->getTRN());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    return true;
                }
            }
        }

        return false;
    }   
    

    
    public static function delete($teacher){
        $path = "";
        if($statement = @Database::getInstance()->prepare("SELECT photo FROM users WHERE id = ?")){
            @$statement->bind_param("i", $teacher->getId());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $path = $row["photo"];
                }
            }
            if( $statement = @Database::getInstance()->prepare("DELETE FROM users WHERE id = ?")){
                @$statement->bind_param("i", $teacher->getId());
                $statement->execute();
                return ["status"=> true, "path"=>$path];
            }
        }
        return ["status" => false];
    }
        
    public static function setPassword($teacher){
        $salt = Security::getSalt();
        $password = ($teacher->getTRN()!= null)?$teacher->getTRN():$teacher->getFirstName();
        $hash= Security::getHash($password, $salt);
        
        return ["salt"=> $salt, "hash"=>$hash];
    }
    
    public static function getFromPost($postVar, $filename=''){
        

        $teacher = new Teacher();
        
        if(strcmp('', $filename)!= 0){
            $teacher->setPhoto($filename);
        }
        
        if(isset($postVar['trn'])){
            $teacher->setTRN($postVar['trn']);
        }
        $teacher->setFirstName($postVar['first_name']);
        $teacher->setLastName($postVar['last_name']);
        
        if(isset($postVar['middle_name'])){
            $teacher->setMiddleName($postVar['middle_name']);
        }
        
        $teacher->setGender($postVar['gender']); 
        $teacher->setMaritalStatus($postVar['marital_status']);
        
        $teacher->setDateOfEmployment(date("Y-m-d", strtotime($postVar['date_of_employment'])));
        $teacher->setRole("Teacher");
        
        if(isset($postVar['email'])){
            $teacher->setEmail($postVar['email']);
        }
        if(isset($postVar['address'])){
            $teacher->setAddress($postVar['address']);
        }
        if(isset($postVar['contact_no1'])){
            $teacher->setContactNo1($postVar['contact_no1']); 
        }
        if(isset($postVar['contact_no2'])){
            $teacher->setContactNo2($postVar['contact_no2']);
        }
        $pass = self::setPassword($teacher);
        $teacher->setPassword($pass['hash']);
        $teacher->setSalt($pass['salt']);
        $teacher->setUsername($teacher->getFirstName());

        return $teacher;
    }
    
    public static function mapObjectFromArray($row){
        global $_CONFIG;
        $teacher = new Teacher();
        $teacher->setPhoto((isset($row['photo']))?$_CONFIG["UPLOADDIR"].$row['photo']:null);
        $teacher->setTRN($row['trn']);
        $teacher->setMaritalStatus($row['marital_status']);
        $teacher->setId($row['id']);
        $teacher->setFirstName($row['first_name']);
        $teacher->setLastName($row['last_name']);
        $teacher->setMiddleName($row['middle_name']);
        $teacher->setGender($row['gender']); 
        $teacher->setUsername($row['username']);
        $teacher->setPassword($row['password']);
        $teacher->setSalt($row['salt']);
        $teacher->setRole($row['role']);
        $teacher->setEmail($row['email']);
        $teacher->setDateOfEmployment($row['date_of_employment']);
        $teacher->setAddress($row['address']);
        $teacher->setContactNo1($row['contact_no1']);    
        $teacher->setContactNo2($row['contact_no2']);
        return $teacher;
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

