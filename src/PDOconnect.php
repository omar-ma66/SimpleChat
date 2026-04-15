<?php
function PDOconnect($param,$base)
{
require($param.".inc.php");
$dsn = "mysql:host=".HOST.";dbname=".$base ;
$user = USER;
$pass = PASS;
$options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            ];
        try
        {
            $idcon = new PDO($dsn,$user,$pass,$options);
                return $idcon ;
        
        }
        catch(PDOException $pdoErr)
            {
                echo "code erreur ".$pdoErr->getCode() . "<br>";
                echo "fichier erreur ".$pdoErr->getFile() . "<br>";
                echo "ligne erreur ".$pdoErr->getLine() . "<br>";
                echo "message erreur ".$pdoErr->getMessage() . "<br>";
                exit();
            }

}