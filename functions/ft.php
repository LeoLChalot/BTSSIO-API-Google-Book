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
        // echo "connexion OK";
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


?>