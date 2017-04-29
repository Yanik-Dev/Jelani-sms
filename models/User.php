<?php 
/**
*user modle 
*@author Alcardo Terlonge
*/
class User {
	private $_username;
	private $_password; 

	public function setUsername($value='')
	{
		$this->_username=$value;
	}

	public function setPassword($value='')
	{
		$this-> _password=$value;
	}
	
	public function getUsername()
	{
		return $this->_username;
	}
	public function getPassword()
	{
		return $this->_password;
	}
}