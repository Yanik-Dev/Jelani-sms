<?php 
require_once '../common/Databaseservice.php'; 
	 
/**
* 
*/
class AuthService 
{
	public static function login($logUser)
	{
		if( $statement = @database::getInstance()->prepare("select * from users where username = ? and password = ?")){
			$statement->bind_param("s", $logUser->getUsername());
			$statement->bind_param("s", $logUser->getPassword());
			$statement->execute();

			var_dump($statement->get_result());
		}
	} 
	
}
?>