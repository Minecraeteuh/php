<?php
session_start();

// Connexion BDD (Identifiants inchangés)
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

// 1. Récupération de l'ID du réalisateur
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_realisateur = $_GET['id'];

// 2. Récupérer les infos du réalisateur
$reqRealisateur = $bdd->prepare("SELECT name FROM realisateurs WHERE id = :id");
$reqRealisateur->execute(['id' => $id_realisateur]);
$realisateur = $reqRealisateur->fetch();

if (!$realisateur) {
    die("Réalisateur introuvable.");
}

// 3. Récupérer tous ses films
$reqFilms = $bdd->prepare("SELECT * FROM films WHERE realisateur_id = :id ORDER BY Sortie DESC");
$reqFilms->execute(['id' => $id_realisateur]);
$films = $reqFilms->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Films de <?php echo htmlspecialchars($realisateur['name']); ?> - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
    <style>
        .director-header {
            padding: 120px 5% 40px;
            background: linear-gradient(to bottom, #181818, #0f0f0f);
            text-align: center;
        }
        .director-header h1 {
            font-size: 3rem;
            color: var(--netflix-red);
        }
        .movie-count {
            color: var(--text-gray);
            font-size: 1.1rem;
        }
    </style>
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

    <section class="director-header">
        <h1><?php echo htmlspecialchars($realisateur['name']); ?></h1>
        <p class="movie-count"><?php echo count($films); ?> film(s) disponible(s)</p>
    </section>

    <main class="main-content">
        <div class="movie-grid">
            <?php if (count($films) > 0): ?>
                <?php foreach ($films as $f): ?>
                    <div class="movie-card">
                        <a href="film_details.php?id=<?php echo $f['id']; ?>">
                            <img src="img/<?php echo htmlspecialchars($f['image']); ?>" alt="<?php echo htmlspecialchars($f['titre']); ?>">
                            <div class="card-details">
                                <h3><?php echo htmlspecialchars($f['titre']); ?></h3>
                                <p class="price"><?php echo $f['prix']; ?>€</p>
                                <span class="btn-add-mini">Voir détails</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun film trouvé pour ce réalisateur.</p>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>