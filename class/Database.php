<?php

class database {
    private $server;
    private $nom;
    private $username;
    private $pwd;

    public function __construct(){
        $this->server = USERNAME;
        $this->nom = DBNAME;
        $this->username = USERNAME;
        $this->pwd = PASSWORD;
    }

    public function connexion(){
        try {
            $connexion = new PDO("mysql:host=" .  $this->server . ";dbname=" . $this->nom . "",  $this->username,  $this->pwd);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connexion->beginTransaction();
        } catch (PDOException $e) {
            $connexion->rollBack();
            echo "Erreur : " . $e->getMessage();
        }
        return $connexion;
    }
}


