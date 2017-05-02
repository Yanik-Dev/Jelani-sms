<?php

include (dirname(__FILE__).'./Config.php');


    header("Location: ./setup-db.php");
    exit;
if (!$link = @mysqli_connect( 'l', 
                       $_CONFIG["DATABASECONFIG"]["USERNAME"],  
                       $_CONFIG["DATABASECONFIG"]["PASSWORD"])) {
    exit;
}

#Make jelani_db the current database
$db_selected = mysqli_select_db($link, $_CONFIG["DATABASECONFIG"]["DATABASE"]);

if (!$db_selected) {

  #If we couldn't, then it either doesn't exist, or we can't see it.
  $sql = 'CREATE DATABASE jelani_db';

  if (mysqli_query($link, $sql)) {
      echo "Database my_db created successfully\n";
  } else {
      echo 'Error creating database: ' . mysql_error() . "\n";
  }
}

mysqli_close($link);
?>