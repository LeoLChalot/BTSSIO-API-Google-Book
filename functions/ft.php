<?php

function str_verify(?string $str): string
{
    $str = htmlspecialchars($str);
    $str = htmlentities($str);
    $str = trim($str);
    return $str;
}
function mail_verify(?string $mail): int
{
    try {
        $connexion = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connexion->beginTransaction();
        // ? Echappement des erreurs et rollback en cas de requêtes râtées
    } catch (PDOException $e) {
        $connexion->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
    // Vérification du mail
    $sth_compare = $connexion->prepare("SELECT COUNT(*) FROM users WHERE mail = '$mail'");
    $sth_compare->execute();
    $compare = $sth_compare->fetch(PDO::FETCH_ASSOC);

    return $compare["COUNT(*)"];
}
function file_transfert(?string $File)
{
    $file = rand(1000, 100000) . "-" . $File;
    $file_loc = $_FILES['profil_picture']['tmp_name'];
    $final_loc = "../assets/img/users/";
    $new_file_name = strtolower($file);
    $final_file = str_replace(' ', '-', $new_file_name);
    $final_file = str_replace('_', '-', $new_file_name);
    move_uploaded_file($file_loc, $final_loc . $final_file);
    var_dump($final_file);
}
