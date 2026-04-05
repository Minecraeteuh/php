<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IMDb & co</title>
    <link rel="stylesheet" href="CSS/inscription.css">
</head>
<body>
    <div class="login-container">
        <h1>Se connecter</h1>
        <p class="subtitle">Connectez-vous à votre compte</p>

        <?php if (isset($_GET['error'])): ?>
            <p style="color: #e50914; text-align: center;">Email ou mot de passe incorrect.</p>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
            <p style="color: #46d369; text-align: center;">Compte créé avec succès ! Connectez-vous.</p>
        <?php endif; ?>

        <form action="traitement_connexion.php" method="post">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="exemple@mail.com" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-connexion">Se connecter</button>
        </form>

        <p class="footer-text">Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></p>
    </div>
</body>
</html>