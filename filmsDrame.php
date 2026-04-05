<?php
session_start();
require_once 'configphp.php';
 
$req = $bdd->prepare("
    SELECT films.*, realisateurs.name AS nom_realisateur
    FROM films
    INNER JOIN liaisongenres ON films.id = liaisongenres.movie_id
    LEFT JOIN realisateurs ON films.realisateur_id = realisateurs.id
    WHERE liaisongenres.genre_id = 1
");
$req->execute();
$films = $req->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films Drame - IMDb & co</title>
    <link rel="stylesheet" href="CSS/filmsDrame.css">
</head>
<body>
 
<header>
    <div class="logo">IMDb & co</div>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="recherche.php">Rechercher</a></li>
            <li><a href="Categorie.php">Catégories</a></li>
            <li><a href="panier.php">Panier</a></li>
        </ul>
    </nav>
</header>
 
<main class="container">
    <h2>Nos films de drame</h2>
    <p class="subtitle">Découvrez notre sélection de films de drame émouvants.</p>
 
    <div class="film-grid">
        <?php if (empty($films)): ?>
            <p class="empty">Aucun film de drame trouvé.</p>
        <?php else: ?>
            <?php foreach ($films as $film): ?>
                <div class="poster-container">
                    <a href="film_details.php?id=<?php echo $film['id']; ?>">
                        <img src="assets/img/<?php echo htmlspecialchars($film['image']); ?>"
                             alt="<?php echo htmlspecialchars($film['titre']); ?>">
                        <div class="overlay">
                            <h3><?php echo htmlspecialchars($film['titre']); ?></h3>
                            <p><?php echo htmlspecialchars($film['nom_realisateur'] ?? 'Inconnu'); ?></p>
                            <span class="prix"><?php echo number_format($film['prix'], 2); ?> €</span>
                            <div class="card-buttons">
                                <a href="panier.php?add=<?php echo $film['id']; ?>" class="btn-acheter">🛒 Panier</a>
                                <a href="film_details.php?id=<?php echo $film['id']; ?>" class="btn-details">Détails</a>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
 
</body>
</html>