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
    if ($user) { $user_pseudo = htmlspecialchars($user['pseudo']); }
}

// On récupère 6 films aléatoires pour les tendances et les 6 derniers pour les nouveautés
$populaires = $bdd->query("SELECT * FROM films ORDER BY RAND() LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
$nouveautes = $bdd->query("SELECT * FROM films ORDER BY Sortie DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);

// Le film de la grande bannière (le premier des populaires)
$hero = $populaires[0] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix Clone - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
</head>
<body class="netflix-body">

    <header class="netflix-header">
        <div class="logo">IMDb & co</div>
        <nav class="main-nav">
            <a href="index.php">Accueil</a>
            <a href="recherche.php">Recherche</a>
            <a href="Categorie.php">Catégories</a>
        </nav>
        <div class="user-nav">
            <a href="panier.php" class="icon">🛒</a>
            <?php if($user_pseudo != "Visiteur"): ?>
                <span class="pseudo">👤 <?php echo $user_pseudo; ?></span>
                <a href="deconnexion.php" class="btn-logout">Quitter</a>
            <?php else: ?>
                <a href="connexion.php" class="btn-red">S'identifier</a>
            <?php endif; ?>
        </div>
    </header>

    <?php if ($hero): ?>
    <section class="hero-section" style="background-image: linear-gradient(to top, #141414, transparent), url('img/<?php echo $hero['image']; ?>');">
        <div class="hero-info">
            <h1 class="hero-title"><?php echo htmlspecialchars($hero['titre']); ?></h1>
            <p class="hero-description"><?php echo htmlspecialchars(substr($hero['description'], 0, 150)); ?>...</p>
            <div class="hero-buttons">
                <a href="details.php?id=<?php echo $hero['id']; ?>" class="btn-white">▶ Lecture</a>
                <a href="ajouter_panier.php?id=<?php echo $hero['id']; ?>" class="btn-gray">🛒 + Panier</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <main class="content-rows">
        <section class="row">
            <h2 class="row-title">Tendances actuelles</h2>
            <div class="row-posters">
                <?php foreach($populaires as $f): ?>
                    <div class="poster-container">
                        <a href="film_details.php?id=<?php echo $f['id']; ?>">
                            <img src="img/<?php echo $f['image']; ?>" alt="<?php echo $f['titre']; ?>" class="poster">
                            <div class="poster-info">
                                <span><?php echo $f['prix']; ?>€</span>
                                <button class="btn-gray">🛒 + Panier</button>
                                <a href="film_details.php?id=<?php echo $f['id']; ?>" class="btn-details">Détails</a>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="row">
            <h2 class="row-title">Nouveautés</h2>
            <div class="row-posters">
                <?php foreach($nouveautes as $f): ?>
                    <div class="poster-container">
                        <a href="film_details.php?id=<?php echo $f['id']; ?>">
                            <img src="img/<?php echo $f['image']; ?>" alt="<?php echo $f['titre']; ?>" class="poster">
                            <div class="poster-info">
                                <span><?php echo $f['prix']; ?>€</span>
                                <button class="btn-gray">🛒 + Panier</button>
                                <a href="film_details.php?id=<?php echo $f['id']; ?>" class="btn-details">Détails</a>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
     <script>
      window.addEventListener('scroll', () => {
        document.querySelector('.netflix-header').classList.toggle('bg-solid', window.scrollY > 40);
      });
    </script>
</body>
</html>