<?php require_once(__DIR__ . '/../require/bdd-on.php');

if (!empty($_GET['func'])) {
    $function = $_GET['func'];
    if (!empty($_SESSION) && ($_SESSION['role'] == 'admin')) {
        switch ($function) {
            case 'userDelete':
                    $userID = $_GET['id'];
                    $sth_userDelete = $connexion->prepare("DELETE FROM users WHERE id = $userID");
                    $sth_userDelete->execute();
                    header('location: ../admin_dashboard.php');
                break;
            case 'userEdit':
                header('location: ../admin_dashboard.php?func=listUsers');
                break;
            case 'msgDelete':
                    $msgID = $_GET['id'];
                    $sth_userDelete = $connexion->prepare("DELETE FROM messages WHERE id = $msgID");
                    $sth_userDelete->execute();
                    header('location: ../admin_dashboard.php');
                break;

            default:
                header('location: ../index.php');
                break;
        }
    }
} else {
    header('location: ../index.php');
}
