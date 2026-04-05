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
        <ul class="user-nav">
            <li><a href="index.php"><img src="assets/logo/home.svg" alt="home" class="home-icon-svg">Accueil</a></li>
            <li><a href="recherche.php"><img src="assets/logo/search.svg" alt="search" class="search-icon-svg">Rechercher</a></li>
            <li><a href="panier.php"><img src="assets/logo/cart.svg" alt="Panier" class="cart-icon-svg">Panier</a></li>
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