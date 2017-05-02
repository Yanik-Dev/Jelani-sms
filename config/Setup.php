<?php

include (dirname(__FILE__).'./Config.php');


    
if (!$link = @mysqli_connect( $_CONFIG["DATABASECONFIG"]["SERVER"]+'t',  $_CONFIG["DATABASECONFIG"]["USERNAME"],  $_CONFIG["DATABASECONFIG"]["PASSWORD"])) {
    header("Location: ./setup-db.php");
}

#Make jelani_db the current database
$db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

#check if database exist
if (!$db_selected) {
    #$commands = file_get_contents("./db.sql");   
    #mysqli_multi_query($link, $commands);
  if (mysqli_query($link, "CREATE DATABASE IF NOT EXIST jelani_db")) {
     
     echo "Database my_db created successfully\n";
     
  } else {
      echo 'Error creating database: ' . mysql_error() . "\n";
  }
}

#Make jelani_db the current database
$db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

#check if school is in database
if ($db_selected){
    if ($result = mysqli_query($link, "SELECT * FROM school")) {
        $count = mysqli_num_rows($result);
        if($count < 1){      
            mysqli_close($link);
            header("Location: ./setup-account.php");
       }
   }
}


mysqli_close($link);
?>