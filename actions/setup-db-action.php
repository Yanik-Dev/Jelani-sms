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
    
    if(count($_POST["forms"]) < 1){
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
    
    $forms = $_POST["forms"];
    Database::getInstance()->autocommit (false);
    #insert the school name
    if($statement = @Database::getInstance()->prepare("INSERT INTO school SET name = ?")){
      @$statement->bind_param("s", $_POST['schoolName']);

            if (!$statement->execute()) {
                echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                Database::getInstance()->rollback();
                die();
            }
            
            #insert the grades associated with the school
            foreach($forms as $form){
                if($statement = @Database::getInstance()->prepare("INSERT INTO forms SET name = ?")){
                   @$statement->bind_param("s", $form);
                    if (!$statement->execute()) {
                            echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                            Database::getInstance()->rollback();
                            die();
                    }
                }
            }
            
            #insert admin user
            $salt = Security::getSalt();
            $hash = Security::getHash($_POST["password"], $salt);
            if( $statement = @Database::getInstance()->prepare("INSERT  INTO users SET username= ?, password = ?, "
                    . " salt= ?, role= 'ADMIN', is_activated = 'yes'")){
                @$statement->bind_param("sss", $_POST['username'], $hash, $salt);

                if (!$statement->execute()) {
                    echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                    Database::getInstance()->rollback();
                    die();
                }

                $year = date('Y');
                if( $statement = @Database::getInstance()->prepare("INSERT  INTO academic_years SET year= ?, is_default = 1")){
                @$statement->bind_param("i",$year);

                    if (!$statement->execute()) {
                        echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
                        Database::getInstance()->rollback();
                        die();
                    }

                    Database::getInstance()->commit();
                    header("Location: ../templates/login.php");
                    exit;

                }
                    echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                    Database::getInstance()->rollback();
                    die();
                

            }else{
                echo "Execute failed: (" . Database::getInstance()->errno . ") " . Database::getInstance()->error;
                Database::getInstance()->rollback();
                die();
            }
    }
}
header("Location: ../templates/login.php");
