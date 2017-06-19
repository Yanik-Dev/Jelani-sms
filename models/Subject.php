<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subject
 *
 * @author Yanik
 */
class Subject {
    private $_id;
    private $_name;
    private $_code;
    private $_teachers;
    
    public function getId(){ return $this->_id; }
    public function setId($id) { $this->_id = $id; }
    
    public function getName() { return $this->_name; }
    public function setName($name) { $this->_name = $name; }
    
    public function getCode() { return $this->_code; }
    public function setCode($code) { $this->_code = $code; }
    
    public function getTeachers() { return $this->_teachers; }
    public function setTeachers($teachers) { $this->_teachers = $teachers; }
        
}
