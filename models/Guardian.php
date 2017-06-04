<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parent
 *
 * @author Yanik
 */
class Guardian extends User{
    private $_profession;    
    private $_student;
    private $_type;
    
    public function getProfession(){ return $this->_profession; }
    public function setProfession($profession) { $this->_profession = $profession; }
    
    public function getChild(){ return $this->_student; }
    public function setChild($student) { $this->_student = $student; }
    
    public function getType(){ return $this->_type; }
    public function setType($_type) { $this->_type = $type; }

}
