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
function file_transfert(?string $FILES): string
{
    $file = rand(1000, 100000) . "-" . $FILES['profil_picture']['name'];
    $file_loc = $FILES['profil_picture']['tmp_name'];
    $final_loc = "../assets/img/users/";
    $new_file_name = strtolower($file);
    $final_file = str_replace(' ', '-', $new_file_name);
    $final_file = str_replace('_', '-', $new_file_name);
    move_uploaded_file($file_loc, $final_loc . $final_file);
    return $final_file;
}
function user_edit(?object $user, ?array $arr): void
{
    $userNom = str_verify($arr[0]);
    $userPrenom = str_verify($arr[1]);
    $userProfession = str_verify($arr[2]);
    $userMail = str_verify($arr[3]);
    $userTelephone = str_verify($arr[4]);
    $userAdresse = str_verify($arr[5]);
    $profile_picture = file_transfert($arr[6]);
    $user->setPrenom($userNom);
    $user->setNom($userPrenom);
    $user->setProfession($userProfession);
    $user->setMail($userMail);
    $user->setTelephone($userTelephone);
    $user->setAdresse($userAdresse);
    $user->setPhoto($profile_picture);
}
function API_Search(?string $title): array
{
    $title = str_replace(' ', '+', $title);
    $url = "https://www.googleapis.com/books/v1/volumes?q=$title&langRestrict=fr&maxResults=18";
    $curl = curl_init($url);
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        CURLOPT_TIMEOUT => 0,
        CURLOPT_URL => $url,
        CURLOPT_CAINFO => __DIR__ . './../assets/Certificat/GTS Root R1.crt'
    );
    curl_setopt_array($curl, $options);
    $resp = curl_exec($curl);
    if ($e = curl_error($curl)) {
        var_dump($e);
    } else {
        $data = json_decode($resp, true);
        $results = $data["items"];
    }
    return $results;
}
