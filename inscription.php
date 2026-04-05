<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - IMDb & co</title>
    <link rel="stylesheet" href="CSS/inscription.css">
</head>
<body>
    <div class="register-container">
        <h1>Créer un compte</h1>
        <p class="subtitle">Créer un compte IMDb & co</p>

        <?php if (isset($_GET['error'])): ?>
            <?php
            $messages = [
                'empty'    => 'Tous les champs sont obligatoires.',
                'email'    => 'Adresse email invalide.',
                'password' => 'Le mot de passe doit faire au moins 6 caractères.',
                'exists'   => 'Cette adresse email est déjà utilisée.',
            ];
            $msg = $messages[$_GET['error']] ?? 'Une erreur est survenue.';
            ?>
            <p style="color: #e50914; text-align: center;"><?php echo htmlspecialchars($msg); ?></p>
        <?php endif; ?>

        <form action="traitement_inscription.php" method="post">
            <div class="input-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
            </div>

            <div class="input-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
            </div>

            <div class="input-group">
                <label for="username">Pseudo</label>
                <input type="text" id="username" name="username" placeholder="Pseudo" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="exemple@mail.com" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe (6 caractères minimum)</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required minlength="6">
            </div>

            <button type="submit" name="ok" class="btn-submit">S'inscrire</button>
        </form>

        <p class="footer-text">Déjà inscrit ? <a href="connexion.php">Connectez-vous</a></p>
    </div>
</body>
</html>