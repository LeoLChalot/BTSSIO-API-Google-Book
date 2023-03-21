<?php
require_once(__DIR__ . '/../require/bdd-on.php');

class User
{
    private $prenom, $nom, $mail, $pwd, $role;

    public function __construct(?string $prenom, ?string $nom, ?string $mail, ?string $pwd, ?string $role)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->pwd = $pwd;
        $this->role = $role;
    }

    public function inscription(): void
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
        $sth_register = $connexion->prepare("INSERT INTO users(nom, prenom, mail, mot_de_passe) VALUES(:nom, :prenom, :mail, :mot_de_passe)");
        $sth_register->bindParam(':nom', $this->prenom);
        $sth_register->bindParam(':prenom', $this->nom);
        $sth_register->bindParam(':mail', $this->mail);
        $sth_register->bindParam(':mot_de_passe', $this->pwd);
        $sth_register->execute();
        header('location: ../login.php');
    }
    public function connexion(): void
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
    }
    public function deconnexion(): void
    {
        session_destroy();
        header('location: ../index.php');
    }
    public function getLastName(): string
    {
        return $this->nom;
    }
    public function setLastName(?string $nom): void
    {
        $this->nom = $nom;
    }
    public function getFirstName(): string
    {
        return $this->prenom;
    }
    public function setFirstName(?string $prenom): void
    {
        $this->prenom = $prenom;
    }
    public function getUsername(): string
    {
        return "$this->prenom $this->nom";
    }
    public function getMail(): string
    {
        return $this->mail;
    }
    public function setMail(?string $mail): void
    {
        $this->mail = $mail;
    }
    public function getRole(): string
    {
        return $this->role;
    }

}
