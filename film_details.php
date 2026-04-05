<?php
session_start();
require_once 'configphp.php';



$film = null;
$acteurs = [];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_film = intval($_GET['id']);

    $query = $bdd->prepare("
        SELECT films.*, realisateurs.name AS nom_realisateur 
        FROM films 
        LEFT JOIN realisateurs ON films.realisateur_id = realisateurs.id 
        WHERE films.id = :id
    ");
    $query->execute(['id' => $id_film]);
    $film = $query->fetch(PDO::FETCH_ASSOC);

    if ($film) {
        $queryActeurs = $bdd->prepare("
            SELECT acteurs.name 
            FROM acteurs 
            JOIN liaisonActeurs ON acteurs.id = liaisonActeurs.acteur_id 
            WHERE liaisonActeurs.movie_id = :id
        ");
        $queryActeurs->execute(['id' => $id_film]);
        $acteurs = $queryActeurs->fetchAll(PDO::FETCH_ASSOC);
    }
}
if (!$film) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($film['titre']); ?> - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/details.css">
</head>
<body class="netflix-body">

    <header class="netflix-header">
        <div class="logo">IMDb & co</div>
        <nav class="main-nav">
            <a href="index.php"><img src="assets/logo/home.svg" alt="home" class="nav-icon">Accueil</a>
            <a href="recherche.php"><img src="assets/logo/search.svg" alt="search" class="nav-icon">Recherche</a>
            <a href="panier.php"><img src="assets/logo/cart.svg" alt="Panier" class="nav-icon"> Panier</a>
        </nav>
    </header>

    <main class="details-container">
        <div class="details-content">
            <div class="details-image">
                <img src="assets/img/<?php echo htmlspecialchars($film['image']); ?>" alt="<?php echo htmlspecialchars($film['titre']); ?>">
            </div>
            
            <div class="details-info">
                <h1 class="movie-title"><?php echo htmlspecialchars($film['titre']); ?></h1>
                
                <div class="meta-info">
                    <span class="year"><?php echo htmlspecialchars($film['Sortie']); ?></span>
                    <span class="price-tag"><?php echo number_format($film['prix'], 2); ?>€</span>
                </div>

                <p class="description"><?php echo nl2br(htmlspecialchars($film['description'])); ?></p>

                <div class="credits">
                    <p><strong>Réalisateur :</strong> 
                        <a href="par_realisateur.php?id=<?php echo $film['realisateur_id']; ?>" class="director-link">
                            <?php echo htmlspecialchars($film['nom_realisateur'] ?? 'Inconnu'); ?>
                        </a>
                    </p>
                    <p><strong>Acteurs :</strong> 
                        <?php 
                        if (!empty($acteurs)) {
                            $noms = array_column($acteurs, 'name');
                            echo htmlspecialchars(implode(', ', $noms));
                        } else {
                            echo "Non renseignés";
                        }
                        ?>
                    </p>
                </div>

                <div class="actions">
                    <a href="panier.php?add=<?php echo $film['id']; ?>" class="btn-acheter">
                        Ajouter au panier - <?php echo number_format($film['prix'], 2); ?>€
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>