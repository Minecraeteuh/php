<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "utilisateurs";

try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

$rep = $bdd->query("SELECT * FROM films WHERE genres = 'Action'");
$films = $rep->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="fr">
    <header>
        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catégorie Action</title>
        <link rel="stylesheet" href="CSS/categorie.css">
    </header>
    <head>
        <h1>Films d'Action</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="recherche.php">Rechercher</a></li>
                <li><a href="categorie.php">Catégories</a></li>
                <li><a href="panier.php">Panier</a></li>
            </ul>
        </nav>
    </head>
    <body>
        <main class="container">
            <h2>Nos films d'action</h2>
            <p>Découvrez notre sélection de films d'action palpitants.</p>
            <div class ="categories">
            <?php if (count($films) == 0) {
                
            echo "<p>Aucun film d'action trouvé.</p>";
        } else {
        foreach ($films as $film) {
        }
        }
        ?>
            <div class="film-card"><a href="films.php"><?php echo $film['image']; ?></a>
                        <h3><?php echo $film['title']; ?></h3>
                        <p>Réalisé par <?php echo $film['realisateur']; ?></p>
                        <p>Genre : <?php echo $film['genre']; ?></p>
                        <p>Prix : <?php echo $film['prix']; ?>€</p>
                        <a href="panier.php?add=<?php echo $film['id']; ?>" class="btn-ajouter">Ajouter au panier</a>
                        <a href="film_details.php?id=<?php echo $film['id']; ?>" class="btn-details">Voir les détails</a></div>
                <div class="film-card"><a href="films.php"><?php echo $film['image']; ?></a>
                    <h3><?php echo $film['title']; ?></h3>
                    <p>Réalisé par <?php echo $film['realisateur']; ?></p>
                    <p>Genre : <?php echo $film['genre']; ?></p>
                    <p>Prix : <?php echo $film['prix']; ?>€</p>
                    <a href="panier.php?add=<?php echo $film['id']; ?>" class="btn-ajouter">Ajouter au panier</a>
                    <a href="film_details.php?id=<?php echo $film['id']; ?>" class="btn-details">Voir les détails</a></div>
              

            </div>
        </main>
    </body>











</html>