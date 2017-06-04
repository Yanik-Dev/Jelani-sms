<?php
require_once("../config/Config.php");
require_once("../common/Database.php");
require_once("../common/Security.php");


if(isset($_GET['db'])){
    $page = "../templates/setup.php?db=true";
    if(!isset($_POST["server"])){
        header("Location: ".$page);
        exit;
    }

    if(!isset($_POST["username"])){
        header("Location: ".$page);
        exit;
    }

    if(!isset($_POST["password"])){
        header("Location: ".$page);
        exit;
    }

    if (!$link = @mysqli_connect($_POST["server"], $_POST["username"], $_POST["password"])) {
        header("Location: ".$page);
        exit;
    }

    $_CONFIG["DATABASECONFIG"]["SERVER"] = $_POST["server"];
    $_CONFIG["DATABASECONFIG"]["USERNAME"] = $_POST["username"];
    $_CONFIG["DATABASECONFIG"]["PASSWORD"] = $_POST["password"];

    file_get_contents('../config/config.conf', false);
    file_put_contents('../config/config.conf', serialize($_CONFIG));
    header("Location: ../templates/setup.php?db=true");
    exit;
}

if(isset($_GET['account'])){
    $page = "../templates/setup.php?account=true";
    if(!isset($_POST["schoolName"])){
        header("Location: ".$page);
        exit;
    }

    if(!isset($_POST["username"])){
        header("Location: ".$page);
        exit;
    }

    if(!isset($_POST["password"])){
        header("Location: ".$page);
        exit;
    }
    
    if(strcmp($_POST["password"], $_POST["confirmPassword"]) != 0){
        header("Location: ".$page);
        exit;
    }
    
    Database::getInstance()->autocommit (false);
    if($statement = @Database::getInstance()->prepare("INSERT INTO school SET name = ?")){
      @$statement->bind_param("s", $_POST['schoolName']);

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                die();
            }
            $salt = Security::getSalt();
            $hash = Security::getHash($password, $salt);
            if( $statement = @Database::getInstance()->prepare("INSERT  INTO users SET username= ?, password = ?, "
                    . " salt= ?, role= 'ADMIN', is_activated = 'yes'")){
                @$statement->bind_param("sss", $_POST['username'], $hash, $salt);
                
                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    die();
                }
                
                Database::getInstance()->commit();
                header("Location: ../templates/login.php");
                exit;

            }else{
                echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                Database::getInstance()->rollback();
                die();
            }
    }
    header("Location: ../templates/setup.php?account=true");
    exit;
}
header("Location: ../templates/login.php");
