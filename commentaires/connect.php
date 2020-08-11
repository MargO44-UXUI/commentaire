<?php

try
{
  $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
  $bdd = new PDO('mysql:host=localhost;dbname=formation','root','',$options); // on se connecte avec les identifiants
}
catch (Exeption $e) // si la connexion echoue
{
  die('Erreur :'.$e->getMessage()); // on affiche le message d'erreur
}

?>