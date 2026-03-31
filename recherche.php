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

$resultats = [];
$recherche_faite = false;

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $recherche_faite = true;
    $query = $_GET['query'];
    $type = $_GET['type']; 


    if ($type == 'realisateur') {
        $sql = "SELECT * FROM movie WHERE director LIKE :search";
    } else {
        $sql = "SELECT * FROM movie WHERE title LIKE :search";
    }

    $req = $bdd->prepare($sql);
    $req->execute(['search' => '%' . $query . '%']);
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Films - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
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
        <h2>Rechercher un film</h2>
        
        <div class="search-box">
            <form action="recherche.php" method="GET">
                <input type="text" name="query" placeholder="Tapez votre recherche..." required 
                       value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                
                <select name="type">
                    <option value="titre" <?php if(isset($_GET['type']) && $_GET['type'] == 'titre') echo 'selected'; ?>>Par Titre</option>
                    <option value="realisateur" <?php if(isset($_GET['type']) && $_GET['type'] == 'realisateur') echo 'selected'; ?>>Par Réalisateur</option>
                </select>
                
                <button type="submit" class="btn-submit">Rechercher</button>
            </form>
        </div>

        <div class="movie-grid">
            <?php if ($recherche_faite): ?>
                <?php if (!empty($resultats)): ?>
                    <?php foreach ($resultats as $film): ?>
                        <div class="movie-card">
                            <h3><?php echo htmlspecialchars($film['title']); ?></h3>
                            <p>De : <?php echo htmlspecialchars($film['director']); ?></p>
                            <p class="price"><?php echo $film['price']; ?> €</p>
                            <a href="details.php?id=<?php echo $film['id']; ?>" class="btn-details">Détails</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-results">Aucun film trouvé pour "<?php echo htmlspecialchars($query); ?>".</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>