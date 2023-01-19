<?php require_once(__DIR__ . '/../require/bdd-on.php');

if (!empty($_GET['func'])) {
    $function = $_GET['func'];

    switch ($function) {

        case 'register':
            // ? Si la confirmation du MDP est confirmée, le script vérifie et éxecute les différentes requêtes
            if ($_POST['mdp'] == $_POST['mdp-repeat']) {
                // ? Préparation d'une requête de vérification de compte éxistant ?
                $sth_compare = $connexion->prepare("SELECT COUNT(*) FROM users WHERE mail = '$userMail'");
                $sth_compare->execute();
                $compare = $sth_compare->fetch(PDO::FETCH_ASSOC);

                if ($compare == 0) {

                    // ? Attribution des entrées utilisateurs
                    $userPrenom = htmlspecialchars($_POST['prenom']);
                    $userNom = htmlspecialchars($_POST['nom']);
                    $userMail = htmlspecialchars($_POST['mail']);
                    $userMDP = htmlspecialchars($_POST['mdp']);
                    // ! Hashage du MDP
                    $userMDP = password_hash($userMDP, PASSWORD_DEFAULT);

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
                    header('location: http://localhost/bootstrap/form-connexion/login.php');
                } else {
                    // ? Si l'adresse mail est déjà utilisée, l'utilisateur est redirigé vers la page d'inscription
                    header('location: http://localhost/bootstrap/form-connexion/register.php');
                }
            } else {
                // ? Si le mot de passe n'est pas correctement saisi, l'utilisateur est redirigé vers la page d'inscription
                header('location: http://localhost/bootstrap/form-connexion/register.php');
            }
            break;

        case 'login':
            // ? Récupération de la saisie login form
            $userMail = htmlspecialchars($_POST['mail']);
            $userMDP = htmlspecialchars($_POST['mdp']);

            // ? Préparation d'une requête de recherche d'identifiants
            $sth_compare = $connexion->prepare("SELECT mail, mot_de_passe FROM users WHERE mail = '$userMail'");
            $sth_compare->execute();
            $userLogin = $sth_compare->fetch(PDO::FETCH_ASSOC);

            // ? Si la requête renvoie un resultat...
            if (!empty($userLogin)) {
                // ? ... et que le mot de passe correspond, on redirige l'utilisateur vers la page d'accueil
                if (password_verify($userMDP, $userLogin['mot_de_passe'])) {

                    // TODO [ GERER LES SESSIONS ET PRIVILEGES ICI]

                    header('location: http://localhost/bootstrap/form-connexion/');
                }
            } else {
                // ? Si les identifiants ne correspondent pas, on redirige l'utilisateur vers le formulaire de connexion
                header('location: http://localhost/bootstrap/form-connexion/login.php');
            }
            break;
    }
} else {
    header('location: http://localhost/bootstrap/form-connexion/');
}
