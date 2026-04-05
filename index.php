<?php
session_start();
require_once 'configphp.php';

$user_pseudo = "Visiteur";
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT pseudo FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) { $user_pseudo = htmlspecialchars($user['pseudo']); }
}

$nouveautes = $bdd->query("SELECT * FROM films ORDER BY RAND() LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);
$populaires = $bdd->query("SELECT * FROM films ORDER BY Sortie DESC LIMIT 6")->fetchAll(PDO::FETCH_ASSOC);

$hero = $nouveautes[0] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMDb & co</title>
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
        <div class="utilisateur-nav">
        <a href="panier.php" class="cart-link">
            <img src="assets/logo/cart.svg" alt="Panier" class="cart-icon">
        </a>
            <?php if($user_pseudo != "Visiteur"): ?>
            <a href="profil.php" class="pseudo-link">
            <img src="assets/logo/account.svg" alt="Profil" class="profile-icon">
            <?php echo $user_pseudo; ?>
        </a>
        <a href="deconnexion.php" class="btn-logout">Quitter</a>
    <?php else: ?>
        <a href="connexion.php" class="btn-red">S'identifier</a>
    <?php endif; ?>
</div>
    </header>

    <?php if ($hero): ?>
    <section class="hero-section" style="background-image: linear-gradient(to top, #141414, transparent), url('assets/img/<?php echo $hero['image']; ?>');">
        <div class="hero-info">
            <h1 class="hero-title"><?php echo htmlspecialchars($hero['titre']); ?></h1>
            <p class="hero-description"><?php echo htmlspecialchars(substr($hero['description'], 0, 150)); ?>...</p>
            <div class="hero-buttons">
                <a href="film_details.php?id=<?php echo $hero['id']; ?>" class="btn-white">Détails</a>
                <a href="panier.php?add=<?php echo $hero['id']; ?>" class="btn-gray">+ Panier</a>
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
                            <img src="assets/img/<?php echo $f['image']; ?>" alt="<?php echo $f['titre']; ?>" class="poster">
                            <div class="poster-info">
                                <span><?php echo $f['prix']; ?>€</span>
                                <button class="btn-gray">Détails</button>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="row">
            <h2 class="row-title">Les plus aimés</h2>
            <div class="row-posters">
                <?php foreach($nouveautes as $f): ?>
                    <div class="poster-container">
                        <a href="film_details.php?id=<?php echo $f['id']; ?>">
                            <img src="assets/img/<?php echo $f['image']; ?>" alt="<?php echo $f['titre']; ?>" class="poster">
                            <div class="poster-info">
                                <span><?php echo $f['prix']; ?>€</span>
                                <button class="btn-gray">Détails</button>
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