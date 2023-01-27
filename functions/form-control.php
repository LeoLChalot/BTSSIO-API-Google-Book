<?php require_once(__DIR__ . '/../require/bdd-on.php');

if (!empty($_GET['func'])) {
    $function = $_GET['func'];
    switch ($function) {

            // ! FT REGISTER
        case 'register':
            // ? Si la confirmation du MDP est confirmée, le script vérifie et éxecute les différentes requêtes
            if ($_POST['mdp'] == $_POST['mdp-repeat']) {

                // ? Attribution des entrées utilisateurs
                $userPrenom = htmlspecialchars($_POST['prenom']);
                $userNom = htmlspecialchars($_POST['nom']);
                $userMail = htmlspecialchars($_POST['mail']);
                $userMDP = htmlspecialchars($_POST['mdp']);
                // ! Hashage du MDP
                $userMDP = password_hash($userMDP, PASSWORD_DEFAULT);

                // ? Préparation d'une requête de vérification de compte éxistant ?
                $sth_compare = $connexion->prepare("SELECT COUNT(*) FROM users WHERE mail = '$userMail'");
                $sth_compare->execute();
                $compare = $sth_compare->fetch(PDO::FETCH_ASSOC);

                if ($compare["COUNT(*)"] == 0) {
                    // ? Préparation d'une requête pour l'ajout du compte dans la BDD
                    $sth_register = $connexion->prepare("INSERT INTO users(nom, prenom, mail, mot_de_passe) 
                    VALUES(:nom, :prenom, :mail, :mot_de_passe)");
                    $sth_register->bindParam(':nom', $userNom);
                    $sth_register->bindParam(':prenom', $userPrenom);
                    $sth_register->bindParam(':mail', $userMail);
                    $sth_register->bindParam(':mot_de_passe', $userMDP);
                    $sth_register->execute();
                    echo "Execution OK";

                    // ? Si tout se passe bien, l'utilisateur est redirigé vers la page de connexion
                    header('location: ../login.php');
                } else {
                    // ? Si l'adresse mail est déjà utilisée, l'utilisateur est redirigé vers la page d'inscription
                    // echo "<script>alert('mail')</script>";
                    header('location: ../register.php');
                }
            } else {
                // ? Si le mot de passe n'est pas correctement saisi, l'utilisateur est redirigé vers la page d'inscription
                header('location: ../register.php');
            }
            break;
            // ! END FT REGISTER
            // ! FT LOGIN
        case 'login':
            // ? Récupération de la saisie login form
            $userMail = htmlspecialchars($_POST['mail']);
            $userMDP = htmlspecialchars($_POST['mdp']);

            // ? Préparation d'une requête de recherche d'identifiants
            $sth_compare = $connexion->prepare("SELECT * FROM users WHERE mail = '$userMail'");
            $sth_compare->execute();
            $userLogin = $sth_compare->fetch(PDO::FETCH_ASSOC);

            // ? Si la requête renvoie un resultat... et que le mot de passe correspond, on redirige l'utilisateur vers la page d'accueil
            if ((!empty($userLogin)) && (password_verify($userMDP, $userLogin['mot_de_passe']))) {
                $_SESSION['role'] = $userLogin['role'];
                $_SESSION['id'] = $userLogin['id'];
                $_SESSION['username'] = $userLogin['prenom'] . " " . $userLogin['nom'];
                $_SESSION['mail'] = $userLogin['mail'];
                header('location: ../index.php');
            } else {
                // ? Si les identifiants ne correspondent pas, on redirige l'utilisateur vers le formulaire de connexion
                header('location: ../login.php');
            }
            break;
            // ! END FT LOGIN
            // ! FT USEREDIT
        case 'userEdit':
            // header('location: ../admin_dashboard.php?func=listUsers');
            if (isset($_SESSION['id'])) {
                if (
                    !empty($_POST['nom'])
                    && !empty($_POST['prenom'])
                    && !empty($_POST['mail'])
                    && !empty($_POST['telephone'])
                    && !empty($_POST['adresse'])
                    && !empty($_POST['profession'])
                    && !empty($_FILES)
                ) {
                    $userId = $_SESSION['id'];
                    $userNom = htmlspecialchars($_POST['nom']);
                    $userPrenom = htmlspecialchars($_POST['prenom']);
                    $userProfession = htmlspecialchars($_POST['profession']);
                    $userMail = htmlspecialchars($_POST['mail']);
                    $userTelephone = htmlspecialchars($_POST['telephone']);
                    $userAdresse = htmlspecialchars($_POST['adresse']);


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
                var_dump($userId, $userNom, $userPrenom, $userMail, $userTelephone, $userAdresse, $userProfession, $final_file);
            } else {
                header('location: ../index.php');
            }
            break;
            // ! END FT USEREDIT
            // ! FT LOGOUT
        case 'logout':
            session_destroy();
            header('location: ../index.php');
            break;
            // ! END FT LOGOUT
            // ! FT SENDMESSAGE
        case 'sendMessage':
            // ? Récupération des informationdeu formulaire de contact
            $mail = htmlspecialchars($_POST['mail']);
            $sujet = htmlspecialchars($_POST['sujet']);
            $message = nl2br(htmlspecialchars($_POST['message']));

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

        default:
            header('location: ../index.php');
            break;
            // ! END FT SENDMESSAGE
    }
} else {
    header('location: ../index.php');
}
