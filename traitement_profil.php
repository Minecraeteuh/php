<?php
session_start();
require_once 'configphp.php';

$user_id = null;
if (isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $reqUser = $bdd->prepare("SELECT id FROM users WHERE email = :email AND token = :token");
    $reqUser->execute([':email' => $_COOKIE['email'], ':token' => $_COOKIE['token']]);
    $user = $reqUser->fetch();
    if ($user) {
        $user_id = $user['id'];
    }
}

if (!$user_id) {
    header("Location: connexion.php");
    exit();
}

if (isset($_POST['change_pwd'])) {
    $new_pwd = $_POST['new_password'] ?? '';

    if (empty($new_pwd)) {
        header("Location: profil.php?error=empty");
        exit();
    }

    if (strlen($new_pwd) < 6) {
        header("Location: profil.php?error=short");
        exit();
    }

    $hashedPassword = password_hash($new_pwd, PASSWORD_DEFAULT);

    $update = $bdd->prepare("UPDATE users SET motDePasse = :motDePasse WHERE id = :id");
    $update->execute([
        ':motDePasse' => $hashedPassword,
        ':id'         => $user_id
    ]);

    header("Location: profil.php?success=1");
    exit();
}

header("Location: profil.php");
exit();