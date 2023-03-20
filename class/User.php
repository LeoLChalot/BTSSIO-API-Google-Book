<?php
require_once(__DIR__ . '/../require/bdd-on.php');

class User
{
    private $prenom, $nom, $mail, $pwd;

    public function __construct($prenom, $nom, $mail, $pwd)
    {
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->mail = $mail;
        $this->pwd = $pwd;
    }

    public function inscription()
    {
        $sth_register = $connexion->prepare("INSERT INTO users(nom, prenom, mail, mot_de_passe) VALUES(:nom, :prenom, :mail, :mot_de_passe)");
        $sth_register->bindParam(':nom', $this->prenom);
        $sth_register->bindParam(':prenom', $this->nom);
        $sth_register->bindParam(':mail', $this->mail);
        $sth_register->bindParam(':mot_de_passe', $this->pwd);
        $sth_register->execute();
    }

    public function connexion()
    {
    }
}
