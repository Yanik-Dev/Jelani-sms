<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validators
 *
 * @author Yanik
 */
class Validators {
    
    public static function isPhoneNumber($value){
        return preg_replace("^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$", '', $value);
    }
    
    
}
