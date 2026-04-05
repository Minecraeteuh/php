<?php
session_start();
require_once 'configphp.php';

if (isset($_POST['ok'])) {
    $nom      = trim($_POST['nom']);
    $prenom   = trim($_POST['prenom']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation basique
    if (empty($nom) || empty($prenom) || empty($username) || empty($email) || empty($password)) {
        header("Location: inscription.php?error=empty");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: inscription.php?error=email");
        exit();
    }

    if (strlen($password) < 6) {
        header("Location: inscription.php?error=password");
        exit();
    }

    $check = $bdd->prepare("SELECT id FROM users WHERE email = :email");
    $check->execute([':email' => $email]);
    if ($check->fetch()) {
        header("Location: inscription.php?error=exists");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $requete = $bdd->prepare("INSERT INTO users (pseudo, nom, prenom, motDePasse, email)
                              VALUES (:pseudo, :nom, :prenom, :motDePasse, :email)");
    $requete->execute([
        ':pseudo'     => $username,
        ':nom'        => $nom,
        ':prenom'     => $prenom,
        ':motDePasse' => $hashedPassword,
        ':email'      => $email
    ]);

    header("Location: connexion.php?registered=1");
    exit();
}

header("Location: inscription.php");
exit();