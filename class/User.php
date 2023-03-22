<?php

class User
{
    private $id, $prenom, $nom, $mail, $pwd, $role;

    public function __construct(?string $prenom, ?string $nom, ?string $mail, ?string $pwd)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->pwd = $pwd;
        $this->role = "user";
    }

    public function PDO_connexion()
    {
        try {
            $connexion = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->beginTransaction();
        } catch (PDOException $e) {
            $connexion->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
        return $connexion;
    }
    public function inscription(): void
    {
        // $connexion = PDO_connexion();
        try {
            $connexion = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . "", USERNAME, PASSWORD);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->beginTransaction();
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
        $sth_register = $connexion->prepare("SELECT id FROM users WHERE mail = '$this->mail'");
        $sth_register->execute();
        $id = $sth_register->fetch(PDO::FETCH_ASSOC);
        $this->id = $id[0];
        
        header('location: ../index.php');
    }
    public function connexion(): void
    {
        // $connexion = PDO_connexion();
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
        $sth_compare = $connexion->prepare("SELECT * FROM users WHERE mail = '$this->mail'");
        $sth_compare->execute();
        $userLogin = $sth_compare->fetch(PDO::FETCH_ASSOC);
        if ((!empty($userLogin)) && (password_verify($this->pwd, $userLogin['mot_de_passe']))) {
            $this->id = $userLogin['id'];
            $this->prenom = $userLogin['prenom'];
            $this->nom = $userLogin['nom'];
            $this->pwd = $userLogin['mot_de_passe'];
            $this->role = $userLogin['role'];
            header('location: ../index.php');
        } else {
            header('location: ../login.php');
        }
    }
    public function deconnexion(): void
    {
        session_destroy();
        header('location: ../index.php');
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
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