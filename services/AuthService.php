<?php require_once '../common/Databaseservice.php'; 
	 
/**
* 
*/
class AuthService 
{
	public static function login($logUser)
	{
		$_data=database::getInstance()->query("select * from users where username ={ $logUser->getUsername()} and password={$logUser->getPassword()}");
		var_dump($_data->fetch_assoc());
	} 
	
}
