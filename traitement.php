<?php
$servername = "localhost";
$username = "root";
$password = "kanken";

try{
    $bdd = new PDO("mysql:host=$servername;dbname=utilisateurs", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

if (isset ($_POST['ok'])){
    // pour voir si ca bug pour la recup des données var_dump($_POST);
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // On liste les colonnes pour être sûr de ne pas se tromper
    $requete = $bdd->prepare("INSERT INTO users (pseudo, nom, prenom, motDePasse, email) 
                            VALUES (:pseudo, :nom, :prenom, :motDePasse, :email)");

    $requete->execute(
        array(
            ':pseudo'     => $username, // J'utilise ton $username pour la colonne pseudo
            ':nom'        => $nom,
            ':prenom'     => $prenom,
            ':motDePasse' => $password,
            ':email'      => $email
        )
    );

    echo "Utilisateur ajouté avec succès !";
    header("Location: index.php");
    $reponse = $requete->fetch(PDO::FETCH_ASSOC);
    var_dump($reponse);
}

?>