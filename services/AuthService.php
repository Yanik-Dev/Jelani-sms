<?php 
require_once dirname(__FILE__).'/../common/Database.php'; 
require_once dirname(__FILE__).'/../models/User.php'; 

	 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
                       var_dump($row);
                    }
                }
        }
        return $user;
    } 

	public static function logout(){

	}
	
}
?>