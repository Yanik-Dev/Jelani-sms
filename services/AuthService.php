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

			if($rows = $statement->get_result()){
				while($rows->fetch_assoc()){
			       var_dump();
				}
			}
		}
	} 

	public static function logout(){

	}
	
}
?>