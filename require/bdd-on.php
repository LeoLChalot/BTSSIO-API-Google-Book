<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet_account_connexion";

// ? Etablissement de la connexion à la base de données
try{
    $connexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->beginTransaction();
    // echo "connexion OK";



// ? Echappement des erreurs et rollback en cas de requêtes râtées
}catch(PDOException $e){
    $connexion->rollBack();
    echo "Erreur : " . $e->getMessage();
}