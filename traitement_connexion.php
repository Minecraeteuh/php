<?php
session_start();
require_once 'configphp.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: connexion.php?error=1");
        exit();
    }

    $req = $bdd->prepare("SELECT * FROM users WHERE email = :email");
    $req->execute([':email' => $email]);
    $rep = $req->fetch(PDO::FETCH_ASSOC);

    if ($rep && password_verify($password, $rep['motDePasse'])) {
        $token = bin2hex(random_bytes(32));

        $upd = $bdd->prepare("UPDATE users SET token = :token WHERE id = :id");
        $upd->execute([':token' => $token, ':id' => $rep['id']]);

        $cookieOptions = [
            'expires'  => time() + (86400 * 30),
            'path'     => '/',
            'secure'   => false, 
            'httponly' => true,
            'samesite' => 'Strict'
        ];

        setcookie("token", $token, $cookieOptions);
        setcookie("email", $email, $cookieOptions);

        header("Location: index.php");
        exit();
    } else {
        header("Location: connexion.php?error=1");
        exit();
    }
}