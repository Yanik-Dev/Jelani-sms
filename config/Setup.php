<?php

include (dirname(__FILE__).'./Config.php');


    
if (!$link = @mysqli_connect( 'l', 
                       $_CONFIG["DATABASECONFIG"]["USERNAME"],  
                       $_CONFIG["DATABASECONFIG"]["PASSWORD"])) {
    header("Location: ./setup-db.php");
    exit;
}

#Make jelani_db the current database
$db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

#check if database exist
if (!$db_selected) {

  if (mysqli_query($link, "CREATE DATABASE jelani_db")) {
     
     echo "Database my_db created successfully\n";

     #Make jelani_db the current database
     $db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

     if ($result = mysqli_query($link, "SELECT * FROM school")) {
        $count = mysqli_num_rows($result);
        if($count < 1){      
            mysqli_close($link);
            header("Location: ./setup-account.php");
        }
     }
     
  } else {
      echo 'Error creating database: ' . mysql_error() . "\n";
  }
}

mysqli_close($link);
?>