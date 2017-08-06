<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Yanik
 */
class User {
    private $_id;    
    private $_photo;
    private $_gender;
    private $_username;
    private $_password;
    private $_dateOfBirth;
    private $_salt;
    private $_isActivated;
    private $_role;
    private $_email;
    private $_firstName;
    private $_lastName;
    private $_middleName;
    private $_address;
    private $_contactNo1;
    private $_contactNo2;
    
    
    public function getId(){ return $this->_id; }
    public function setId($id) { $this->_id = $id; }
    
    public function getPhoto(){ return $this->_photo; }
    public function setPhoto($photo) { $this->_photo = $photo; }
    
    public function getDateOfBirth(){ return $this->_dateOfBirth; }
    public function setDateOfBirth($dateOfBirth) { $this->_dateOfBirth = $dateOfBirth; }
    
    public function getGender(){ return $this->_gender; }
    public function setGender($gender) { $this->_gender = $gender; }
    
    public function getUsername(){ return $this->_username; }
    public function setUsername($username) { $this->_username = $username; }
    
    public function getPassword(){ return $this->_password; }
    public function setPassword($password) { $this->_password = $password; }
    
    public function getSalt(){ return $this->_salt; }
    public function setSalt($salt) { $this->_salt = $salt; }
    
    public function getIsActivated(){ return $this->_isActivated; }
    public function setIsActivated($isActivated) { $this->_isActivated = $isActivated; }
    
    public function getRole(){ return $this->_role; }
    public function setRole($role) { $this->_role = $role; }
    
    public function getEmail(){ return $this->_email; }
    public function setEmail($email) { $this->_email = $email; }
    
    public function getFirstName(){ return $this->_firstName; }
    public function setFirstName($firstName) { $this->_firstName = $firstName; }
    
    public function getLastName(){ return $this->_lastName; }
    public function setLastName($lastName) { $this->_lastName = $lastName; }
    
    public function getMiddleName(){ return $this->_middleName; }
    public function setMiddleName($middleName) { $this->_middleName = $middleName; }
    
    public function getAddress(){ return $this->_address; }
    public function setAddress($address) { $this->_address = $address; }
    
    public function getContactNo1(){ return $this->_contactNo1; }
    public function setContactNo1($contactNo1) { $this->_contactNo1 = $contactNo1; }
    
    public function getContactNo2(){ return $this->_contactNo2; }
    public function setContactNo2($contactNo2) { $this->_contactNo2 = $contactNo2; }

    public function getFullName() { return $this->_firstName.' '.$this->_lastName; }
}
