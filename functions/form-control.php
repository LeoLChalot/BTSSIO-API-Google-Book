<?php
include(__DIR__ . '/../require/bdd-on.php');
include 'ft.php';
include '../class/Book.php';
if (!empty($_GET['func'])) {
    $function = $_GET['func'];
    switch ($function) {
        case 'register':
            if ($_POST['mdp'] == $_POST['mdp-repeat']) {
                $userPrenom = str_verify($_POST['prenom']);
                $userNom = str_verify($_POST['nom']);
                $userMail = str_verify($_POST['mail']);
                $userMDP = str_verify($_POST['mdp']);
                $userMDP = password_hash($userMDP, PASSWORD_DEFAULT);
                if (mail_verify($userMail) == 0) {
                    $user = new User($userPrenom, $userNom, $userMail, $userMDP, "user");
                    $_SESSION['user'] = $user;
                    $_SESSION['user']->inscription();
                }
            }
            header('location: ../register.php');
            break;
        case 'login':
            $userMail = str_verify($_POST['mail']);
            $userMDP = str_verify($_POST['mdp']);
            $user = new User('', '', $userMail, $userMDP, '');
            $user->connexion();
            $_SESSION['user'] = $user;
            break;
        case 'userEdit':
            if (isset($_SESSION['user'])) {
                $userId = $_SESSION['user']->getId();
                if (!empty($_POST['nom']) 
                && !empty($_POST['prenom']) 
                && !empty($_POST['mail']) 
                && !empty($_POST['telephone']) 
                && !empty($_POST['adresse']) 
                && !empty($_POST['profession']) 
                && !empty($_FILES)) {
                    $infos = array($_POST['nom'], $_POST['prenom'], $_POST['profession'], $_POST['mail'], $_POST['telephone'], $_POST['adresse'], $_FILES);
                    user_edit($_SESSION['user'], $infos);
                    header('location: ../user-profil.php');
                }
            } else {
                header('location: ../index.php');
            }
            break;
        case 'logout':
            $_SESSION['user']->deconnexion();
            break;
        case 'sendMessage':
            $mail = str_verify($_POST['mail']);
            $sujet = str_verify($_POST['sujet']);
            $message = nl2br(str_verify($_POST['message']));
            $date = new DateTime();
            $date->setTimezone(new \DateTimeZone('Europe/Paris'));
            $dateJour = $date->format("d/m/Y");
            $dateHeure = $date->format("H:i");
            $dateGlobal = array(
                $dateJour,
                $dateHeure
            );
            $date = implode(' - ', $dateGlobal);
            if (!empty($_SESSION)) {
                $userId = $_SESSION['user']->getId();
                $isRegister = true;
            } else {
                $userId = null;
                $isRegister = false;
            }
            $sth_send = $connexion->prepare(
                "INSERT INTO messages(`id_user`, `mail`, `isRegister`, `sujet`, `msg`, `dateEnvoi`)
                VALUES(:id_user, :mail, :isRegister, :sujet, :msg, :dateEnvoi)");
            $sth_send->bindParam(':id_user', $userId);
            $sth_send->bindParam(':mail', $mail);
            $sth_send->bindParam(':isRegister', $isRegister);
            $sth_send->bindParam(':sujet', $sujet);
            $sth_send->bindParam(':msg', $message);
            $sth_send->bindParam(':dateEnvoi', $date);
            $sth_send->execute();
            header('location: ../index.php');
            break;
        case 'addBook':
            $id_user = $_SESSION['user']->getId();
            $book = new Book();
            $book = $book->search_book_id($_GET['bookId']);
            $book_id = $book['id'];
            var_dump($book_id);
            die();
            $req_verif = $connexion->prepare(
                "SELECT COUNT(*) 
                FROM biblio_perso 
                WHERE book_id = '$book_id'");
            $req_verif->execute();
            $compare = $req_verif->fetch(PDO::FETCH_ASSOC);
            if ($compare["COUNT(*)"] == 0) {
                $req_add = $connexion->prepare(
                    "INSERT INTO biblio_perso(`book_id`, `title`, `subtitle`, `description`, `pageCount`, `img`, `id_user`)
                    VALUES(:book_id, :title, :subtitle, :description, :pageCount, :img, :id_user)");
                $req_add->bindParam(':book_id', $book['id']);
                $req_add->bindParam(':title', $book['volumeInfo']['title']);
                $req_add->bindParam(':subtitle', $book['volumeInfo']['subtitle']);
                $req_add->bindParam(':description', $book['volumeInfo']['description']);
                $req_add->bindParam(':pageCount', $book['volumeInfo']['pageCount']);
                $req_add->bindParam(':img', $book['volumeInfo']['imageLinks']['smallThumbnail']);
                $req_add->bindParam(':id_user', $id_user);
                $req_add->execute();
                // $_SESSION['user']->add_to_collection($book);
                header('location: ../index.php');
            } else {
                header('location: ../catalogue.php');
            }
            break;
        case 'deleteBook':
            if (!empty($_GET['idBook'])) {
                $id_user = $_SESSION['user']->getId();
                $book_id = $_GET['idBook'];

                $req_sup = $connexion->prepare(
                    "DELETE FROM `biblio_perso` 
                    WHERE book_id = :book_id 
                    AND id_user = :id_user"
                );
                $req_sup->bindParam(':book_id', $book_id);
                $req_sup->bindParam(':id_user', $id_user);
                $req_sup->execute();
                header('location: ../user-collection.php');
            } else {
                header('location: ../index.php');
            }
            break;
        default:
            header('location: ../index.php');
            break;
    }
} else {
    header('location: ../index.php');
}
