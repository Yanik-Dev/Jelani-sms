<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Class
 *
 * @author Yanik
 */
class Classroom {
    private $_classId;
    private $_className;
    private $_grade;
    
    public function __construct($id=0, $name="", $grade=null) {
        $this->_classId = $id;
        $this->_className = $name;
        $this->_grade = $grade;
    }
 
    
    public function getId(){ return $this->_classId; }
    public function setId($id) { $this->_classId = $id; }
    
    public function getName() { return $this->_className; }
    public function setName($name) { $this->_className = $name; }
        
    public function getGrade() { return $this->_grade; }
    public function setGrade($grade) { $this->_grade = $grade; }
    
}
