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
        <p class="subtitle">Rejoignez la communauté IMDb & co</p>
        
        <form action="traitement.php" method="post">
            <div class="input-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
            </div>

            <div class="input-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
            </div>

            <div class="input-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Pseudo" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="exemple@mail.com" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" name="ok" class="btn-submit">S'inscrire</button>
        </form>
        
        <p class="footer-text">Déjà inscrit ? <a href="login.php">Connectez-vous</a></p>
    </div>
</body>
</html>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Valider les données (exemple simple)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<p style='color:red;'>Adresse email invalide.</p>";
            exit;
        }

        // Hash du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Connexion à la base de données (exemple avec PDO)
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insérer les données dans la base de données
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            echo "<p style='color:green;'>Inscription réussie!</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erreur: " . $e->getMessage() . "</p>";
        }
    }
    ?>