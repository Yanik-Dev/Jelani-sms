<?php
require_once dirname(__FILE__).'./User.php';
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
class Student extends User{
    private $_srn;
    private $_academicYear;
    private $_class;
        
    public function getSRN(){ return $this->_srn; }
    public function setSRN($srn) { $this->_srn = $srn; }
    
    public function getAcademicYear(){ return $this->_academicYear; }
    public function setAcademicYear($academicYear) { $this->_academicYear = $academicYear; }
    
    public function getClass(){ return $this->_class; }
    public function setClass($class) { $this->_class = $class; }
    

}