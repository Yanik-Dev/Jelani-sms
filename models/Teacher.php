<?php
require_once './User.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teacher
 *
 * @author Yanik
 */
class Teacher extends User{
    private $_trn;
    private $_maritalStatus;  
    private $_dateOfemployment;

    public function getTRN(){ return $this->_trn; }
    public function setTRN($trn) { $this->_trn = $trn; }
    
    public function getMaritalStatus(){ return $this->_maritalStatus; }
    public function setMaritalStatus($maritalStatus) { $this->_maritalStatus = $maritalStatus; }
    
    public function getDateOfemployment(){ return $this->_dateOfemployment; }
    public function setDateOfemployment($dateOfemployment) { $this->_dateOfemployment = $dateOfemployment; }
    
    
}
