<?php
include_once("../config/Config.php");

if(!isset($_POST['submitBtn'])){
    header("Location: ../templates/setup-db.php");
}

if(!isset($_POST["server"])){
    header("Location: ../templates/setup-db.php");
}

if(!isset($_POST["username"])){
    header("Location: ../templates/setup-db.php");
}

if(!isset($_POST["password"])){
    header("Location: ../templates/setup-db.php");
}

if (!$link = @mysqli_connect($_POST["server"], $_POST["username"], $_POST["password"])) {
    header("Location: ../templates/setup-db.php");
    exit;
}

$_CONFIG["DATABASECONFIG"]["SERVER"] = $_POST["server"];
$_CONFIG["DATABASECONFIG"]["USERNAME"] = $_POST["username"];
$_CONFIG["DATABASECONFIG"]["PASSWORD"] = $_POST["password"];

file_get_contents('../config/config.conf', false);
file_put_contents('../config/config.conf', serialize($_CONFIG));

?>