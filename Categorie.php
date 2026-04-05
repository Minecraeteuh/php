<?php
session_start();
require_once 'configphp.php';


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
        <div class="utilisateur-nav">
            <a href="index.php" class="nav-icon-link"><img src="assets/logo/home.svg" alt="home" class="nav-icon">Accueil</a>
            <a href="recherche.php" class="nav-icon-link"><img src="assets/logo/search.svg" alt="search" class="nav-icon">Rechercher</a>
            <a href="panier.php" class="cart-link"><img src="assets/logo/cart.svg" alt="Panier" class="cart-icon">Panier</a>
        </div>
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