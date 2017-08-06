<?php 
require_once dirname(__FILE__).'/../common/Database.php'; 
require_once dirname(__FILE__).'/../models/User.php'; 

/**
 * Description of AuthService
 *
 * @author Yanik
 */
class AuthService 
{
    public static function login($logUser)
    {
        $user = new User();
        if( $statement = @Database::getInstance()->prepare("select * from users where username = ?")){
                @$statement->bind_param("s", $logUser->getUsername());
                $statement->execute();

                if($rows = $statement->get_result()){
                    while($row = $rows->fetch_assoc()){
                       $user->setFirstName($row["first_name"]);
                       $user->setUsername($row["username"]);
                       $user->setLastName($row["last_name"]);
                       $user->setId($row["id"]);
                       $user->setPassword($row["password"]);
                       $user->setSalt($row["salt"]);
                       $user->setGender($row["gender"]);
                       $user->setIsActivated($row["is_activated"]);
                       $user->setRole($row["role"]);
                    }
                }
        }
        return $user;
    } 

	public static function logout(){
        unset($_SESSION['user']);
	}
	
}
?>