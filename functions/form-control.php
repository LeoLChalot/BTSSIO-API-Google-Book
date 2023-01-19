<?php require_once(__DIR__ . '/../require/bdd-on.php');

if (!empty($_GET['func'])) {
    $function = $_GET['func'];
    // var_dump($function);
    // var_dump($_GET);
    // var_dump($_POST['nom']);

    switch ($function) {
        case 'register':
            // ? Si la confirmation du MDP est confirmée
            if ($_POST['mdp'] == $_POST['mdp-repeat']) {

                // ? Attribution des entrées utilisateurs
                $userPrenom = htmlspecialchars($_POST['prenom']);
                $userNom = htmlspecialchars($_POST['nom']);
                $userMail = htmlspecialchars($_POST['mail']);
                $userMDP = htmlspecialchars($_POST['mdp']);

                // ! Hashage du MDP
                $userMDP = password_hash($userMDP, PASSWORD_DEFAULT);
                // var_dump($userPrenom, $userNom, $userMail, $userMDP);

                // ? Utilisation une requête préparée pour l'ajout du compte dans la BDD
                $ft_register = $connexion->prepare("INSERT INTO users(nom, prenom, mail, mot_de_passe) VALUES(:nom, :prenom, :mail, :mot_de_passe)");
                $ft_register->bindParam(':nom', $userNom);
                $ft_register->bindParam(':prenom', $userPrenom);
                $ft_register->bindParam(':mail', $userMail);
                $ft_register->bindParam(':mot_de_passe', $userMDP);
                $ft_register->execute();
                // echo "Execution OK";

                // ? Si tout se passe bien, l'utilisateur est redirigé vers la page de connexion
                header('location: http://localhost/bootstrap/form-connexion/login.php');
            } else {
                header('location: http://localhost/bootstrap/form-connexion/register.php');
            }
            break;
        case 'login':

            break;
    }
} else {
    header('location: http://localhost/bootstrap/form-connexion/');
}
