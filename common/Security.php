<?php

class Security{
    
    public static function getHash($password, $salt) {
        return hash("sha256", $password . $salt);
    }

    public static function getSalt(){
        $intermediateSalt = md5(uniqid(rand(), true));
        $salt = substr($intermediateSalt, 0, 6);
        return $salt;
    }

    public static function encrypt($value){
        return urlencode(base64_encode($value));
    }

    public static function decrypt($value){
        return base64_decode(urlencode($value));
    }
}