<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
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
    <title>Catégories - IMDb & co</title>
    <link rel="stylesheet" href="CSS/categorie.css">
</head>
<body>
    <header>
        <h1>IMDb & co</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="recherche.php">Rechercher</a></li>
                <li><a href="panier.php">Panier</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Nos Catégories</h2>
        <p>Explorez nos différentes catégories de films.</p>
        <div class="categories">
            <button class="categorie-card"><a href="filmsAction.php">Action</a></button>
            <button class="categorie-card"><a href="filmsDrame.php">Drame</a></button>
        </div>
    </main>
</body>
</html>