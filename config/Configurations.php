<?php

/**
 * Project Configurations
 * Contains all the configurations for external services
 * such as database, uploads folder, etc.
 *
 * USAGE: 
 *  include in your php template or services
 *  then access the associative arrays by.
 *  $_CONFIG["DATABASE"]["SERVER"] to get server name
 */
$_CONFIG = [
    "DATABASE" => [
        "SERVER" =>"127.0.0.1",
        "USERNAME" => "root",
        "PASSWORD" => "",
        "DATABASE" => "jelani_db"
    ]
];
