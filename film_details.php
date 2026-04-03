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

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_film = $_GET['id'];

$query = $bdd->prepare("
    SELECT films.*, realisateurs.name AS nom_realisateur 
    FROM films 
    LEFT JOIN realisateurs ON films.realisateur_id = realisateurs.id 
    WHERE films.id = :id
");
$query->execute(['id' => $id_film]);
$film = $query->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    die("Film non trouvé.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($film['titre']); ?> - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/details.css">
</head>
<body>

    <header class="netflix-nav">
        <div class="logo">IMDb & co</div>
        <nav class="nav-links">
            <a href="index.php">Accueil</a>
            <a href="recherche.php">Recherche</a>
            <a href="Categorie.php">Catégories</a>
        </nav>
    </header>

    <main class="details-container">
        <div class="details-content">
            <div class="details-image">
                <img src="img/<?php echo htmlspecialchars($film['image']); ?>" alt="<?php echo htmlspecialchars($film['titre']); ?>">
            </div>
            
            <div class="details-info">
                <h1 class="movie-title"><?php echo htmlspecialchars($film['titre']); ?></h1>
                
                <div class="meta-info">
                    <span class="year"><?php echo htmlspecialchars($film['Sortie']); ?></span>
                    <span class="price-tag"><?php echo htmlspecialchars($film['prix']); ?>€</span>
                </div>

                <p class="description">
                    <?php echo nl2br(htmlspecialchars($film['description'])); ?>
                </p>

                <div class="credits">
                    <p><strong>Réalisateur :</strong> 
                        <a href="par_realisateur.php?id=<?php echo $film['realisateur_id']; ?>" class="director-link">
                            <?php echo htmlspecialchars($film['nom_realisateur'] ?? 'Inconnu'); ?>
                        </a>
                    </p>
                    <p><strong>Acteurs :</strong> <?php echo htmlspecialchars($film['acteurs'] ?? 'Non renseignés'); ?></p>
                </div>

                <div class="actions">
                    <a href="panier.php?add=<?php echo $film['id']; ?>" class="btn-buy">
                        🛒 Ajouter au panier - <?php echo $film['prix']; ?>€
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>