<?php
require (dirname(__FILE__).'./Config.php');

#check if database is configured
if (!$link = @mysqli_connect( $_CONFIG["DATABASECONFIG"]["SERVER"],  $_CONFIG["DATABASECONFIG"]["USERNAME"],  $_CONFIG["DATABASECONFIG"]["PASSWORD"])) {
    header("Location: ./setup.php?db=true");
}

#Make jelani_db the current database
$db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

#check if database exist
if (!$db_selected) {
  
  #create database 
  if (mysqli_query($link, "CREATE DATABASE IF NOT EXISTS jelani_db")) {


    $commands = file_get_contents(dirname(__FILE__)."./db.sql");  
    #create database tables
    if(mysqli_multi_query($link, $commands)){

    }else {
        echo 'Error creating database: ' . mysqli_error($link) . "\n";
        mysqli_close($link);
    }

  } else {
      echo 'Error creating database: ' . mysqli_error($link) . "\n";
      mysqli_close($link);
  }
}
mysqli_close($link);

#check if database is configured
if (!$link = @mysqli_connect( $_CONFIG["DATABASECONFIG"]["SERVER"],  $_CONFIG["DATABASECONFIG"]["USERNAME"],  $_CONFIG["DATABASECONFIG"]["PASSWORD"])) {
    header("Location: ./setup.php?db=true");
}

#Make jelani_db the current database
$db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

#check if school is in database
if ($db_selected){
    if ($result = mysqli_query($link, "SELECT * FROM school")) {
        $count = mysqli_num_rows($result);
        if($count < 1){      
            header("Location: ./setup.php?account=true");
            exit;
       }
    }else{  
      echo 'Error creating database: ' . mysqli_error($link) . "\n";
      mysqli_close($link);
      exit;
    }
}


