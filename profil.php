<?php
session_start();
require_once 'configphp.php';

$user = null;
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT * FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch(PDO::FETCH_ASSOC);
}

if (!$user) {
    header("Location: connexion.php");
    exit();
}

$reqAchats = $bdd->prepare("SELECT date_achat, prix_achat FROM achats WHERE user_id = :user_id ORDER BY date_achat DESC");
$reqAchats->execute(['user_id' => $user['id']]);
$mes_achats = $reqAchats->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - IMDb & co</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/profil.css">
</head>
<body class="netflix-body">

    <header class="netflix-header">
        <div class="logo">IMDb & co</div>
        <nav class="main-nav">
            <a href="index.php"><img src="assets/logo/home.svg" alt="home" class="nav-icon">Accueil</a>
            <a href="recherche.php"><img src="assets/logo/search.svg" alt="search" class="nav-icon">Recherche</a>
            <a href="Categorie.php"><img src="assets/logo/categorie.svg" alt="categorie" class="nav-icon">Catégories</a>
        </nav>
        <div class="user-nav">
             <a href="panier.php" class="cart-link"><img src="assets/logo/cart.svg" alt="Panier" class="nav-icon"></a>
             <a href="profil.php" class="pseudo-link">
                <img src="assets/logo/account.svg" alt="Profil" class="nav-icon">
                <?php echo htmlspecialchars($user['pseudo']); ?>
             </a>
             <a href="deconnexion.php" class="btn-logout">Quitter</a>
        </div>
    </header>

    <main class="profil-container">
        <h1 class="row-title">Mon Profil</h1>

        <div class="profil-grid">
            <section class="profil-card">
                <h2>Mes Informations</h2>
                <div class="info-list">
                    <p><strong>Nom :</strong> <?php echo htmlspecialchars($user['nom']); ?></p>
                    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user['prenom']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </section>

            <section class="profil-card">
                <h2>Sécurité</h2>
                <form action="traitement_profil.php" method="POST">
                    <div class="input-group">
                        <label>Nouveau mot de passe</label>
                        <input type="password" name="new_password" placeholder="••••••••" required>
                    </div>
                    <button type="submit" name="change_pwd" class="btn-red">Mettre à jour</button>
                </form>
            </section>
        </div>

        <section class="purchases-section">
            <h2>Historique des commandes</h2>
            <?php if (empty($mes_achats)): ?>
                <p class="empty-msg">Aucun achat enregistré.</p>
            <?php else: ?>
                <div class="purchases-list">
                    <?php foreach ($mes_achats as $achat): ?>
                        <div class="purchase-item">
                            <div class="purchase-info">
                                <h3>Commande effectuée</h3>
                                <p>Le <?php echo date('d/m/Y à H:i', strtotime($achat['date_achat'])); ?></p>
                                <span class="price"><?php echo number_format($achat['prix_achat'], 2); ?> €</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>