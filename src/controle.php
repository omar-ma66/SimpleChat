<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST")
  header("location:../public/index.php?serveur-erreur=no-post-method");

if (!isset($_POST["pseudo"]) || empty($_POST["pseudo"]))
  header("location:../public/index.php?serveur-erreur=pseudo-ou-pass-probleme");

if (!isset($_POST["pass"]) || empty($_POST["pass"]))
  header("location:../public/index.php?serveur-erreur=pseudo-ou-pass-probleme");



require("PDOconnect.php");
$idcon = PDOconnect("param", "chat");

$pseudo = htmlspecialchars($_POST["pseudo"]);
$pass   = htmlspecialchars($_POST["pass"]);
$oui = "oui";

$query = "SELECT * from users where pseudo = :pseudo and pass = :pass";


$reqPreparer = $idcon->prepare($query);
$data = ["pseudo" => $pseudo, "pass" => $pass];


$rep = $reqPreparer->execute($data);

if ($reqPreparer->rowCount() == 0) {
  $idcon = null;
  $reqPreparer->closeCursor();
  header("location:../public/index.php?serveur-erreur=pseudo-pass-incorrecte");
} else {
  // $reqPreparer->closeCursor();


  $infoUser =  $reqPreparer->fetch(PDO::FETCH_ASSOC);
  if ($infoUser) {
    $_SESSION['user_id'] = $infoUser["user_id"];
    $_SESSION['pseudo'] = $infoUser["pseudo"];
    $_SESSION['present'] = "oui";
    $idcon->exec("UPDATE present set connecter='oui' where pseudo = '{$infoUser['pseudo']}'" );
    header("location:chatDialog.php");
  }
}

?>


