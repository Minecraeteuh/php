<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "kanken";
$dbname = "utilisateurs";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les Films</title>
    <link rel="stylesheet" href="CSS/categorie.css">
</head>
<body>
    <header>
        <h1>Nos Films</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="recherche.php">Rechercher</a></li>
                <li><a href="categorie.php">Catégories</a></li>
                <li><a href="panier.php">Panier</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>