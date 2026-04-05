<?php
session_start();
require_once 'configphp.php';

$user_id = null;
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT id FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) {
        $user_id = $user['id'];
    }
}

if (!$user_id || empty($_SESSION['panier'])) {
    header("Location: panier.php");
    exit();
}

$ids = implode(',', array_map('intval', $_SESSION['panier']));
$reqFilms = $bdd->query("SELECT SUM(prix) as total FROM films WHERE id IN ($ids)");
$result = $reqFilms->fetch();
$montant_total = $result['total'];

$insert = $bdd->prepare("INSERT INTO achats (user_id, prix_achat, date_achat) VALUES (:uid, :prix, NOW())");
$insert->execute([
    'uid'  => $user_id,
    'prix' => $montant_total
]);

$_SESSION['panier'] = array();

header("Location: profil.php?order_success=1");
exit();
?>