<?php
session_start();
require_once 'configphp.php';

// 1. Vérification de la connexion (comme sur tes autres pages)
$user_id = null;
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT id FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) {
        $user_id = $user['id'];
    }
}

// Sécurité : Si pas de panier ou pas connecté, on dégage
if (!$user_id || empty($_SESSION['panier'])) {
    header("Location: panier.php");
    exit();
}

// 2. Calcul du montant total
$ids = implode(',', array_map('intval', $_SESSION['panier']));
$reqFilms = $bdd->query("SELECT SUM(prix) as total FROM films WHERE id IN ($ids)");
$result = $reqFilms->fetch();
$montant_total = $result['total'];

// 3. Insertion dans la table achats
// On utilise la structure simplifiée que tu as choisie
$insert = $bdd->prepare("INSERT INTO achats (user_id, prix_achat, date_achat) VALUES (:uid, :prix, NOW())");
$insert->execute([
    'uid'  => $user_id,
    'prix' => $montant_total
]);

// 4. On vide le panier après le succès
$_SESSION['panier'] = array();

// 5. Redirection vers le profil pour voir la commande
header("Location: profil.php?order_success=1");
exit();
?>