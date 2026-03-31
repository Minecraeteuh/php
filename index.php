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
    die("Erreur de connexion : " . $e->getMessage());
}


$user_pseudo = "Visiteur";
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT pseudo FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) {
        $user_pseudo = htmlspecialchars($user['pseudo']);
    }
}


try {
    $reqPopulaires = $bdd->query("SELECT * FROM movie ORDER BY views DESC LIMIT 3");
    $populaires = $reqPopulaires->fetchAll(PDO::FETCH_ASSOC);

    $reqNouveautes = $bdd->query("SELECT * FROM movie ORDER BY id DESC LIMIT 3");
    $nouveautes = $reqNouveautes->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $populaires = [];
    $nouveautes = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body>
    <header>
        <div class="nav-container">
            <h1>IMDb & co</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="recherche.php">Recherche</a></li>
                    <li><a href="Categorie.php">Catégories</a></li>
                    <li><a href="panier.php">🛒 Panier</a></li>
                    <?php if($user_pseudo != "Visiteur"): ?>
                        <li><a href="profil.php" class="user-link">👤 Ton profil: <?php echo $user_pseudo; ?></a></li>
                        <li><a href="deconnexion.php" class="btn-logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="connexion.php" class="btn-login">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Bienvenue <?php echo $user_pseudo; ?> !</h2>
            <p>Découvrez les meilleurs films du moment.</p>
        </section>

        <section class="movie-section">
            <h2>🔥 Nos films populaires</h2>
            <div class="movie-grid">
                <?php if (!empty($populaires)): ?>
                    <?php foreach($populaires as $film): ?>
                        <div class="movie-card">
                            <img src="img/<?php echo $film['image']; ?>" alt="<?php echo $film['titre']; ?>">
                            <h3><?php echo $film['titre']; ?></h3>
                            <p class="price"><?php echo $film['prix']; ?> €</p>
                            <div class="actions">
                                <a href="details.php?id=<?php echo $film['id']; ?>" class="btn-details">Détails</a>
                                <a href="ajouter_panier.php?id=<?php echo $film['id']; ?>" class="btn-add">🛒 +</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-msg">Bientôt disponible... (Remplissez la table 'movies')</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="movie-section">
            <h2>✨ Nos nouveaux films</h2>
            <div class="movie-grid">
                <?php if (!empty($nouveautes)): ?>
                    <?php foreach($nouveautes as $film): ?>
                        <div class="movie-card">
                            <h3><?php echo $film['titre']; ?></h3>
                            <p class="price"><?php echo $film['prix']; ?> €</p>
                            <a href="details.php?id=<?php echo $film['id']; ?>" class="btn-details">Détails</a>
                            <a href="ajouter_panier.php?id=<?php echo $film['id']; ?>" class="btn-add">Ajouter</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="movie-card placeholder">
                        <div class="img-placeholder">IMAGE</div>
                        <h3>Film Démo</h3>
                        <p class="price">9.99 €</p>
                        <button class="btn-add" disabled>Ajouter</button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>