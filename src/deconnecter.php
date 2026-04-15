<?php
session_start();


require("PDOconnect.php");
$idcon = PDOconnect("param", "chat");
$query = "UPDATE present set connecter = 'non' where pseudo = '{$_SESSION['pseudo']}'";
$idcon->exec($query);
session_destroy();
session_unset();
header("location:../public/index.php");
?>