<?php
include(__DIR__ . '/../require/bdd-on.php');
// include(__DIR__ . '/../class/User.php');
include 'ft.php';
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
                } else {
                    header('location: ../register.php');
                }
            } else {
                header('location: ../register.php');
            }
            break;

        case 'login':
            $userMail = str_verify($_POST['mail']);
            $userMDP = str_verify($_POST['mdp']);
            $user = new User('', '', $userMail, $userMDP, '');
            $user->connexion();
            $_SESSION['user'] = $user;
            var_dump($_SESSION['user']);
            // die();
            break;

        case 'userEdit':
            if (isset($_SESSION['user'])) {
                $userId = $_SESSION['user']->getId();
                if (
                    !empty($_POST['nom'])
                    && !empty($_POST['prenom'])
                    && !empty($_POST['mail'])
                    && !empty($_POST['telephone'])
                    && !empty($_POST['adresse'])
                    && !empty($_POST['profession'])
                    && !empty($_FILES)
                ) {

                    $userNom = str_verify($_POST['nom']);
                    $userPrenom = str_verify($_POST['prenom']);
                    $userProfession = str_verify($_POST['profession']);
                    $userMail = str_verify($_POST['mail']);
                    $userTelephone = str_verify($_POST['telephone']);
                    $userAdresse = str_verify($_POST['adresse']);

                    $file = rand(1000, 100000) . "-" . $_FILES['profil_picture']['name'];
                    $file_loc = $_FILES['profil_picture']['tmp_name'];
                    $final_loc = "../assets/img/users/";
                    $new_file_name = strtolower($file);
                    $final_file = str_replace(' ', '-', $new_file_name);
                    $final_file = str_replace('_', '-', $new_file_name);
                    move_uploaded_file($file_loc, $final_loc . $final_file);

                    $sth_edit = $connexion->prepare("UPDATE users SET 
                    `nom` = :nom, 
                    `prenom` = :prenom, 
                    `profession` = :profession, 
                    `mail` = :mail, 
                    `telephone` = :telephone, 
                    `adresse` = :adresse, 
                    `profil_picture` = :profil_picture 
                    WHERE `id` = :id
                    ");

                    $sth_edit->bindParam(':nom', $userNom);
                    $sth_edit->bindParam(':prenom', $userPrenom);
                    $sth_edit->bindParam(':profession', $userProfession);
                    $sth_edit->bindParam(':mail', $userMail);
                    $sth_edit->bindParam(':telephone', $userTelephone);
                    $sth_edit->bindParam(':adresse', $userAdresse);
                    $sth_edit->bindParam(':profil_picture', $final_file);
                    $sth_edit->bindParam(':id', $userId);
                    $sth_edit->execute();
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
            // ? Récupération des informationdeu formulaire de contact
            $mail = str_verify($_POST['mail']);
            $sujet = str_verify($_POST['sujet']);
            $message = nl2br(str_verify($_POST['message']));

            // ? Récupération de la date pour dater le message
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
                // ? Si l'utilisateur est connecté, on affect le userID au message
                $userId = $_SESSION['id'];
                $isRegister = true;
            } else {
                // ? Sinon on laisse le userID à NULL
                $userId = null;
                $isRegister = false;
            }
            // ? Enregistrement du message dans la table "messages"
            $sth_send = $connexion->prepare("INSERT INTO messages(`id_user`, `mail`, `isRegister`, `sujet`, `msg`, `dateEnvoi`)VALUES(:id_user, :mail, :isRegister, :sujet, :msg, :dateEnvoi)");
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
            break;

        default:
            header('location: ../index.php');
            break;
    }
} else {
    header('location: ../index.php');
}
