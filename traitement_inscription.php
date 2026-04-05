<?php
session_start();
require_once 'configphp.php';



if (isset ($_POST['ok'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $requete = $bdd->prepare("INSERT INTO users (pseudo, nom, prenom, motDePasse, email ) 
                            VALUES (:pseudo, :nom, :prenom, :motDePasse, :email)");

    $requete->execute(
        array(
            ':pseudo'     => $username, 
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