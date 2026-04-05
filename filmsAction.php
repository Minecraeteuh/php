<?php
session_start();
require_once 'configphp.php';

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Jointure correcte : films + liaisongenres pour récupérer les vrais champs
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
    <link rel="stylesheet" href="CSS/filmsAction.css">
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
    <h2>Nos films d'action</h2>
    <p class="subtitle">Découvrez notre sélection de films d'action palpitants.</p>

    <div class="movie-grid">
        <?php if (empty($films)): ?>
            <p class="empty">Aucun film d'action trouvé.</p>
        <?php else: ?>
            <?php foreach ($films as $film): ?>
                <div class="poster-container">
                    <a href="film_details.php?id=<?php echo $film['id']; ?>">
                        <img src="assets/img/<?php echo htmlspecialchars($film['image']); ?>"
                             alt="<?php echo htmlspecialchars($film['titre']); ?>">
                        <div class="overlay">
                            <h3><?php echo htmlspecialchars($film['titre']); ?></h3>
                            <p><?php echo htmlspecialchars($film['nom_realisateur'] ?? 'Inconnu'); ?></p>
                            <span class="price"><?php echo number_format($film['prix'], 2); ?> €</span>
                            <div class="card-buttons">
                                <a href="ajouter_panier.php?id=<?php echo $film['id']; ?>" class="btn-cart">🛒 Panier</a>
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