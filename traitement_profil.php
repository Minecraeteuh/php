<?php
session_start();
require_once 'configphp.php';

// 1. Vérification de la connexion
$user_id = null;
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT id FROM users WHERE email = :email AND token = :token");
    $reqUser->execute(['email' => $_COOKIE['email'], 'token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) {
        $user_id = $user['id'];
    }
}

if (!$user_id) {
    header("Location: connexion.php");
    exit();
}

// 2. Traitement du changement de mot de passe
if (isset($_POST['change_pwd'])) {
    $new_pwd = $_POST['new_password'];

    if (!empty($new_pwd)) {
        // CORRECTION ICI : On utilise 'motDePasse' au lieu de 'password'
        $update = $bdd->prepare("UPDATE users SET motDePasse = :motDePasse WHERE id = :id");
        $update->execute([
            'motDePasse' => $new_pwd,
            'id' => $user_id
        ]);

        header("Location: profil.php?success=1");
        exit();
    } else {
        header("Location: profil.php?error=empty");
        exit();
    }
} else {
    header("Location: profil.php");
    exit();
}
?>