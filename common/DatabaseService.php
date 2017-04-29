<?php

/**
 * Database class
 * Defines Database connection
 */
 class Database{
    private static $instance = null;

    /**
     * return connection to database
     * @return Mysqli Connection
     */
    public static function getInstance(){
        if(self::$instance == null){
             self::$instance = new Mysqli("localhost", "root", "" , "");
            if (self::$instance->connect_errno) {
                echo "Failed to connect to MySQL: (" . self::$instance->connect_errno . ") " . self::$instance->connect_error;
            }
        }
        return self::$instance;
    }
}


?>