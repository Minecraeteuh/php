<?php
session_start();
require_once 'configphp.php';

$sql = "SELECT films.*, genres.nom AS nom_genre 
        FROM films 
        JOIN liaisonGenres ON films.id = liaisonGenres.movie_id 
        JOIN genres ON liaisonGenres.genre_id = genres.id ";

$query = $bdd->query($sql);
$tous_les_films = $query->fetchAll(PDO::FETCH_ASSOC);

$categories = [];
foreach ($tous_les_films as $f) {
    $genre = $f['nom_genre'];
    if (!isset($categories[$genre])) {
        $categories[$genre] = [];
    }
    $categories[$genre][] = $f;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue par Catégories - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body class="body"> 
    <header class="header">
        <div class="logo">IMDb & co</div>
        <nav class="main-nav">
            <a href="index.php">Accueil</a>
            <a href="recherche.php">Recherche</a>
            <a href="films.php">Tous les films</a>
        </nav>
    </header>

    <main class="content-rows" style="margin-top: 100px;">
        <h1 class="row-title" style="font-size: 2.5rem; margin-left: 10px;">Parcourir par genre</h1>

        <?php if (empty($categories)): ?>
            <p style="margin-left: 50px;">Aucun film ou catégorie trouvé.</p>
        <?php else: ?>
            <?php foreach ($categories as $nom_genre => $liste_films): ?>
                <section class="row">
                    <h2 class="row-title"><?php echo htmlspecialchars($nom_genre); ?></h2>
                    <div class="row-posters">
                        <?php foreach ($liste_films as $f): ?>
                            <div class="poster-container">
                                <a href="film_details.php?id=<?php echo $f['id']; ?>">
                                    <img src="assets/img/<?php echo $f['image']; ?>" alt="<?php echo htmlspecialchars($f['titre']); ?>" class="poster">
                                    <div class="poster-info">
                                        <span class="price"><?php echo number_format($f['prix'], 2); ?>€</span>
                                        <button class="btn-gray">🛒 + Panier</button>
                                        <span class="btn-details">Détails</span>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <script>
        window.addEventListener('scroll', () => {
            document.querySelector('.netflix-header').classList.toggle('bg-solid', window.scrollY > 40);
        });
    </script>
</body>
</html>