<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grade
 *
 * @author Yanik
 */
class Grade {
    private $_gradeId;
    private $_gradeName;
    
    public function __construct($id=0, $name='') {
        $this->_gradeId = $id;
        $this->_gradeName = $name;
    }
    
    public function getId(){ return $this->_gradeId; }
    public function setId($id) { $this->_gradeId = $id; }
    
    public function getName() { return $this->_gradeName; }
    public function setName($name) { $this->_gradeName = $name; }
}
