<?php
session_start();
require_once 'configphp.php';



$user_logged = false;
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT id FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) { $user_logged = true; }
}

if (!$user_logged) {
    header("Location: connexion.php");
    exit();
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

if (isset($_GET['add'])) {
    $id_film = intval($_GET['add']);
    if (!in_array($id_film, $_SESSION['panier'])) {
        $_SESSION['panier'][] = $id_film;
    }
    header("Location: panier.php"); // Pour nettoyer l'URL
    exit();
}

if (isset($_GET['remove'])) {
    $id_remove = intval($_GET['remove']);
    if (($key = array_search($id_remove, $_SESSION['panier'])) !== false) {
        unset($_SESSION['panier'][$key]);
    }
    header("Location: panier.php");
    exit();
}

if (isset($_GET['clear'])) {
    $_SESSION['panier'] = array();
    header("Location: panier.php");
    exit();
}

$films_panier = [];
$total = 0;

if (!empty($_SESSION['panier'])) {
    $ids = implode(',', array_map('intval', $_SESSION['panier']));
    $reqFilms = $bdd->query("SELECT * FROM films WHERE id IN ($ids)");
    $films_panier = $reqFilms->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($films_panier as $f) {
        $total += $f['prix'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - IMDb & co</title>
    <link rel="stylesheet" href="CSS/panier.css">
    <link rel="stylesheet" href="CSS/index.css">
   
</head>
<body class="netflix-body">

    <header class="netflix-header">
        <div class="logo">IMDb & co</div>
        <nav class="main-nav">
            <a href="index.php"><img src="assets/logo/home.svg" alt="home" class="home-icon-svg">Accueil</a>
            <a href="recherche.php"><img src="assets/logo/search.svg" alt="search" class="search-icon-svg">Rechercher</a>
            <a href="Categorie.php"><img src="assets/logo/categorie.svg" alt="categorie" class="categorie-icon-svg">Catégories</a>
        </nav>
    </header>

    <main class="cart-container">
        <h1 class="row-title">Votre Panier</h1>

        <?php if (empty($films_panier)): ?>
            <div class="empty-msg">
                <p>Votre panier est vide pour le moment.</p>
                <br>
                <a href="index.php" class="btn-red">Découvrir des films</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Film</th>
                        <th>Titre</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($films_panier as $f): ?>
                        <tr>
                            <td><img src="assets/img/<?php echo $f['image']; ?>" class="img-cart"></td>
                            <td><?php echo htmlspecialchars($f['titre']); ?></td>
                            <td><?php echo $f['prix']; ?> €</td>
                            <td><a href="panier.php?remove=<?php echo $f['id']; ?>" class="btn-delete">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-section">
                <p>Montant total : <span class="total-price"><?php echo number_format($total, 2); ?> €</span></p>
                <div class="cart-actions">
                    <a href="panier.php?clear=1" class="btn-clear">Vider le panier</a>
                    <a href="valider_paiement.php" class="btn-checkout">Procéder au paiement</a>
            </div>
</div>
        <?php endif; ?>
    </main>

</body>
</html>