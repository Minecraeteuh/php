<?php
session_start();
require_once 'configphp.php';

$resultats = [];
$recherche_faite = false;

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $recherche_faite = true;
    $query = $_GET['query'];
    $type = $_GET['type']; 

    if ($type == 'titre') {
        $sql = "SELECT films.*, realisateurs.name AS nom_realisateur 
                FROM films 
                LEFT JOIN realisateurs ON films.realisateur_id = realisateurs.id 
                WHERE films.titre LIKE :search";
    } else {
        $sql = "SELECT films.*, realisateurs.name AS nom_realisateur 
                FROM films 
                LEFT JOIN realisateurs ON films.realisateur_id = realisateurs.id 
                WHERE realisateurs.name LIKE :search";
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
    <title>Recherche IMDb & co</title>
    <link rel="stylesheet" href="CSS/recherche.css">
</head>
<body>

<header>
    <h1>IMDb & co</h1>
    <nav>
        <ul>
            <li><img src="assets/logo/home.svg" alt="home" class="home-icon-svg"><a href="index.php">Accueil</a></li>
            <li><img src="assets/logo/categorie.svg" alt="categorie" class="categorie-icon-svg"><a href="Categorie.php">Catégories</a></li>
            <li><img src="assets/logo/cart.svg" alt="Panier" class="cart-icon-svg"><a href="panier.php">Mon Panier</a></li>
        </ul>
    </nav>
</header>

<div class="search-container">
    <h2>Trouver un film</h2>
    <form action="recherche.php" method="GET">
        <input type="text" name="query" placeholder="Titre ou réalisateur..." required 
               value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>" 
               style="width: 50%; padding: 10px; border-radius: 5px; border: none;">
        
        <select name="type" style="padding: 10px; border-radius: 5px;">
            <option value="titre" <?php if(isset($_GET['type']) && $_GET['type'] == 'titre') echo 'selected'; ?>>Par Titre</option>
            <option value="realisateur" <?php if(isset($_GET['type']) && $_GET['type'] == 'realisateur') echo 'selected'; ?>>Par Réalisateur</option>
        </select>
        
        <button type="submit" style="padding: 10px 20px; background: #e50914; color: white; border: none; border-radius: 5px; cursor: pointer;">Rechercher</button>
    </form>
</div>

<main>
    <div class="movie-grid">
        <?php if ($recherche_faite): ?>
            <?php if (!empty($resultats)): ?>
                <?php foreach ($resultats as $film): ?>
                    <div class="poster-container">
                        <img src="assets/img/<?php echo $film['image']; ?>" alt="<?php echo htmlspecialchars($film['titre']); ?>">
                        <h3><?php echo htmlspecialchars($film['titre']); ?></h3>
                        <p><strong>Réalisateur :</strong> <?php echo htmlspecialchars($film['nom_realisateur'] ?? 'Inconnu'); ?></p>
                        <p><strong>Année :</strong> <?php echo htmlspecialchars($film['Sortie']); ?></p>
                        <p><em><?php echo htmlspecialchars(substr($film['description'], 0, 100)); ?>...</em></p>
                        <p class="price"><?php echo number_format($film['prix'], 2); ?> €</p>
                        <a href="film_details.php?id=<?php echo $film['id']; ?>" class="btn-details">Voir détails</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #888;">Aucun résultat trouvé pour "<?php echo htmlspecialchars($query); ?>".</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>