<?php
class User
{
    private ?int $id;
    private ?string $prenom;
    private ?string $nom;
    private ?string $mail;
    private ?string $pwd;
    private ?string $role;
    private ?string $profession;
    private ?string $telephone;
    private ?string $adresse;
    private ?string $profile_picture;
    private ?array $collection = [];

    public function __construct(?string $prenom, ?string $nom, ?string $mail, ?string $pwd)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->pwd = $pwd;
        $this->role = "user";
    }
    public function add_to_collection(?object $book): void
    {
        array_push($this->collection, $book);
    }

    // * ACTIONS
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
        $connexion = $this->PDO_connexion();
        $sth_register = $connexion->prepare("INSERT INTO users(nom, prenom, mail, mot_de_passe) VALUES(:nom, :prenom, :mail, :mot_de_passe)");
        $sth_register->bindParam(':nom', $this->prenom);
        $sth_register->bindParam(':prenom', $this->nom);
        $sth_register->bindParam(':mail', $this->mail);
        $sth_register->bindParam(':mot_de_passe', $this->pwd);
        $sth_register->execute();
        $sth_register = $connexion->prepare("SELECT id FROM users WHERE mail = ?");
        $sth_register->execute([$this->mail]);
        $user = $sth_register->fetch();
        $this->id = $user[0];
        header('location: ../index.php');
    }
    public function connexion(): void
    {
        $connexion = $this->PDO_connexion();
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

    // * GETTERS
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getUsername(): string
    {
        return "$this->prenom $this->nom";
    }
    public function getMail(): string
    {
        return $this->mail;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getProfession(): string
    {
        return $this->profession;
    }
    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function getAdresse(): string
    {
        return $this->adresse;
    }
    public function getPhoto(): string
    {
        return $this->profile_picture;
    }
    public function getCollection(): array
    {
        return $this->collection;
    }

    // * SETTERS
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `nom` = :nom WHERE `id` = $this->id");
        $sth_edit->bindParam(':nom', $this->nom);
        $sth_edit->execute();
    }
    public function setPrenom(?string $prenom): void
    {
        $this->prenom = $prenom;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `prenom` = :prenom WHERE `id` = $this->id");
        $sth_edit->bindParam(':prenom', $this->prenom);
        $sth_edit->execute();
    }
    public function setMail(?string $mail): void
    {
        $this->mail = $mail;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `mail` = :mail WHERE `id` = $this->id");
        $sth_edit->bindParam(':mail', $this->mail);
        $sth_edit->execute();
    }
    public function setProfession($profession): void
    {
        $this->profession = $profession;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `profession` = :profession WHERE `id` = $this->id");
        $sth_edit->bindParam(':profession', $this->profession);
        $sth_edit->execute();
    }
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `telephone` = :telephone WHERE `id` = $this->id");
        $sth_edit->bindParam(':telephone', $this->telephone);
        $sth_edit->execute();
    }
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `adresse` = :adresse WHERE `id` = $this->id");
        $sth_edit->bindParam(':adresse', $this->adresse);
        $sth_edit->execute();
    }
    public function setPhoto($profile_picture): void
    {
        $this->profile_picture = $profile_picture;
        $connexion = $this->PDO_connexion();
        $sth_edit = $connexion->prepare("UPDATE users SET `profil_picture` = :profil_picture WHERE `id` = $this->id");
        $sth_edit->bindParam(':profil_picture', $this->profile_picture);
        $sth_edit->execute();
    }
}
