<?php
session_start();
 ?>



<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>page de connection</title>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>

  <form action="../src/controle.php" method="post">
    <fieldset>
      <legend>se connecter</legend>
      <div class="boite">
        <label for="id-pseudo">PSEUDO</label>
        <input type="text" id="id-pseudo" name="pseudo" require>
      </div>
      <div class="boite">
        <label for="id-pass">PASS</label>
        <input type="password" id="id-pass" name="pass" require>
      </div>
    </fieldset>
    <fieldset>
      <input type="submit" value="Se Connecter">
    </fieldset>
  </form>



</body>



</html>