<?php
include 'C:\wamp64\www\librairie\Librairie\class\User.php';
define("SERVERNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DBNAME", "tp_libraire");

// ? Etablissement de la connexion à la base de données
try {
    $connexion = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME."", USERNAME, PASSWORD);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connexion->beginTransaction();
    // echo "connexion OK";
    // ? Echappement des erreurs et rollback en cas de requêtes râtées
} catch (PDOException $e) {
    $connexion->rollBack();
    echo "Erreur : " . $e->getMessage();
}

session_start();
$id_session = session_id();
// var_dump($id_session);
if (!empty($_SESSION['id'])) {
    $userID = $_SESSION['id'];
}

