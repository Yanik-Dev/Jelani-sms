<?php
require_once dirname(__FILE__).'/../models/User.php';
require_once dirname(__FILE__).'/../common/Security.php';
require_once dirname(__FILE__).'/../common/Database.php';
require_once dirname(__FILE__).'/../config/Config.php';

/**
 * Description of user
 *
 * @author 
 */
class UserService {

    public static function insert($user){
        if( $statement = @Database::getInstance()->prepare("INSERT INTO users SET photo = ?, role = ?, username = ?, "
                                                            . "password = ?, salt = ? , is_activated = 'yes'")){
            @$statement->bind_param("sssss",      
                                    $user->getPhoto(),
                                    $user->getRole(),   
                                    $user->getUsername(),
                                    $user->getPassword(),
                                    $user->getSalt()
                                   );

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                return false;
            }
            
        }else{
            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
            return false;
        }
      
        return true;
    }  
    
    public static function update($user){
        if( $statement = @Database::getInstance()->prepare("UPDATE users SET photo = ?, role = ?, username = ?, "
                                                            . "password = ?, salt = ? WHERE id = ?")){
            @$statement->bind_param("sssssi",                                
                                            $user->getPhoto(),  
                                            $user->getRole(),          
                                            $user->getUsername(),
                                            $user->getPassword(),
                                            $user->getSalt(),
                                            $user->getId()
                                           );

             if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    return false;
            }
        }else{
            echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
            return false;
        }
        
      
        return true;
    }  
    
    public static function findOne($id){
        $user = new user();
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM users WHERE id = ?")){
            @$statement->bind_param("i", $id);
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $user = self::mapObjectFromArray($row);
                }
            }
        }

        return $user;
    }

    public static function findAll(){
        $users = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM users")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $user = self::mapObjectFromArray($row);
                    $users[$i] = $user;
                    $i++;
                }
            }
        }
        return $users;
    }

    public static function findLimit($limit){
        $users = [];
        $i = 0;
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM users order by id desc limit 0,$limit")){
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $user = self::mapObjectFromArray($row);
                    $users[$i] = $user;
                    $i++;
                }
            }
        }
        return $users;
    }

    public static function exist($user){
        if( $statement = @Database::getInstance()->prepare("SELECT * FROM users WHERE username = ? ")){
            @$statement->bind_param("s", $user->getUsername());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    return true;
                }
            }
        }

        return false;
    }   
    
  
    
    public static function delete($user){
        $path = "";
        if($statement = @Database::getInstance()->prepare("SELECT photo FROM users WHERE id = ?")){
            @$statement->bind_param("i", $user->getId());
            $statement->execute();
            if($rows = $statement->get_result()){
                while($row = $rows->fetch_assoc()){
                    $path = $row["photo"];
                }
            }
            if( $statement = @Database::getInstance()->prepare("DELETE FROM users WHERE id = ?")){
                @$statement->bind_param("i", $user->getId());
                $statement->execute();
                return ["status"=> true, "path"=>$path];
            }
        }
        return ["status" => false];
    }
    
    
    public static function setPassword($pass){
        $salt = Security::getSalt();
        $password = $pass;
        $hash= Security::getHash($password, $salt);
        
        return ["salt"=> $salt, "hash"=>$hash];
    }
    
    public static function getUserFromPost($postVar, $filename=''){
        
      
        
        $user  = new User(); 
        if(strcmp('', $filename)!= 0){
            $user->setPhoto($filename);
        }     
        if(isset($postVar['username'])){
            $user->setUsername($postVar['username']);
        }
        if(isset($postVar['role'])){
            $user->setRole($postVar['role']);
        }
        
        $pass = self::setPassword($postVar['password']);
        $user->setPassword($pass['hash']);
        $user->setSalt($pass['salt']);

        return $user;
    }
    
    public static function mapObjectFromArray($row){
        global $_CONFIG;
        $user = new User();
        $user->setPhoto((isset($row['photo']))?$_CONFIG["UPLOADDIR"].$row['photo']:null);
        $user->setId($row['id']);
        $user->setFirstName($row['first_name']);
        $user->setLastName($row['last_name']);
        $user->setRole($row['role']); 
        $user->setUsername($row['username']);
        return $user;
    }
    
    public static function validateInputs($input){
        
   
        if(strcmp(trim($input['username'],"") == 0)){
            
        }
        if(strcmp(trim($input['password'],"") == 0)){
            
        }
       
        if(strcmp(trim($input['password']), trim($input['confirmPassword'])) != 0){
                
        }
        
    }
}

