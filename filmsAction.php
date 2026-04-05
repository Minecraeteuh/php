<?php
session_start();
require_once 'configphp.php';

$req = $bdd->prepare("
    SELECT films.*, realisateurs.name AS nom_realisateur
    FROM films
    INNER JOIN liaisongenres ON films.id = liaisongenres.movie_id
    LEFT JOIN realisateurs ON films.realisateur_id = realisateurs.id
    WHERE liaisongenres.genre_id = 2
");
$req->execute();
$films = $req->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films Action - IMDb & co</title>
    <link rel="stylesheet" href="CSS/categorie2.css">
</head>
<body>

<header>
    <div class="logo">IMDb & co</div>
    <div class="utilisateur-nav">
        <a href="index.php"><img src="assets/logo/home.svg" alt="home" class="nav-icon">Accueil</a>
        <a href="recherche.php"><img src="assets/logo/search.svg" alt="search" class="nav-icon">Rechercher</a>
        <a href="Categorie.php"><img src="assets/logo/categorie.svg" alt="categorie" class="nav-icon">Catégories</a>
        <a href="panier.php"><img src="assets/logo/cart.svg" alt="panier" class="nav-icon">Panier</a>
    </div>
</header>

<main class="container">
    <h2>Nos films d'action</h2>
    <p class="subtitle">Découvrez notre sélection de films d'action palpitants.</p>

    <div class="film-grid">
        <?php if (empty($films)): ?>
            <p class="empty">Aucun film d'action trouvé.</p>
        <?php else: ?>
            <?php foreach ($films as $film): ?>
                <div class="poster-container">
                    <img src="assets/img/<?php echo htmlspecialchars($film['image']); ?>"
                         alt="<?php echo htmlspecialchars($film['titre']); ?>">
                    <div class="overlay">
                        <h3><?php echo htmlspecialchars($film['titre']); ?></h3>
                        <p><?php echo htmlspecialchars($film['nom_realisateur'] ?? 'Inconnu'); ?></p>
                        <span class="prix"><?php echo number_format($film['prix'], 2); ?> €</span>
                        <div class="card-buttons">
                            <a href="panier.php?add=<?php echo $film['id']; ?>" class="btn-acheter">+ Panier</a>
                            <a href="film_details.php?id=<?php echo $film['id']; ?>" class="btn-details">Détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>