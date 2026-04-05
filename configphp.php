<?php

$servername = "localhost";
$username = "root";
$password = "kanken"; // mot de passe de votre base de données, assurez-vous qu'il est correct
$dbname = "utilisateurs"; // nom de votre base de données


try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}


?>