//* connexion.php */
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="CSS/inscription.css">
</head>
<body>
    <div class="login-container">
        <h1>Se connecter</h1>
        <p class="subtitle">Connectez-vous à votre compte</p>
        
        <form action="traitement_connexion.php" method="post">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" name="ok" class="btn-submit">Se connecter</button>
        </form>
        
        <p class="footer-text">Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
    </div>

   <?php
if(isset($_GET['error'])) {
    echo '<p style="color:red;">Email ou mot de passe incorrect.</p>';
}
?>


</html>