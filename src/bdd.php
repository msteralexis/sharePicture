<?php

class Bdd {
    // information connection bdd

    protected $serverName = 'localhost';
    protected $userName = 'ioio';
    protected $password = 'ioio';
    protected $bddName = "toto";
    private $conn = '';

    // Constructeur
    public function __construct() {
        $this->connectionBdd();
    }

    private function connectionBdd(){
        // Connection bdd 
        try {
            $this->conn = new PDO("mysql:host=$this->serverName;dbname=$this->bddName; charset=utf8", $this->userName, $this->password);
            //On définit le mode d'erreur de PDO sur Exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        /*On capture les exceptions si une exception est lancée et on affiche
        *les informations relatives à celle-ci*/ catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }


    // Déconnection à la BDD
    public function closeConnection() {
        $this->conn = null;
    }

    // Vérification de la connection d'un utilisateur (avec le login et mot de passe qu'il a renseigner)
    public function connection($mail, $password) {
        $pasword = md5( $password ); 
        $res = $this->conn->prepare("Select * from user where mail = ? and mdp = ? ");
        $res->execute(array($mail, $pasword)) ;
        return $res->fetch();
    }


    // insertion d'un nouvelle utilisateurs
    public function insertUser($nom, $prenom, $mail, $mdp) {
        $mdp = md5( $mdp ); 
        $res =  $this->conn->prepare(" INSERT INTO user (nom, prenom, mail, mdp)  VALUES ( ?, ?, ?, ? )");
        return $res->execute( array( $nom, $prenom, $mail, $mdp )) ;
    }

    // vérification de l'existance d'un utilsiateurs avec son mail
    public function userExistantMail( $mail) {
        $res = $this->conn->prepare("Select * from user where mail = ?  ");
        $res->execute(array($mail )) ;
        return $res->fetch();
    }

    // vérification de l'existance d'un utilsiateurs avec son id
    public function userExistantId( $id ) {
        $res = $this->conn->prepare("Select * from user where id = ?  ");
        $res->execute(array($id )) ;
        return $res->fetch();
    }

    // conneciton d'un utilsiateurs avec son mail et son mot de passe
    public function userConnection( $mail, $mdp ) {
        $mdp = md5( $mdp ); 
        $res = $this->conn->prepare("Select * from user where mail = ? and mdp = ? ");
        $res->execute(array($mail, $mdp )) ;
        return $res->fetch();
    }

    // modification d'un utilisateurs et reconnaisance par son id
    public function modificationtUser( $nom, $prenom, $mail, $id ) { 
        $res = $this->conn->prepare("Update user set nom=?, prenom=?, mail=? where id = ?  ");
        return $res->execute(array($nom, $prenom, $mail, $id )) ;
    }

    // modification du mot de passe d'un utilsiateurs avec cryptage et reconnaisance par son id
    public function modificationtMDPUser( $mdp, $id ) { 
        $mdp = md5($mdp);
        $res = $this->conn->prepare("Update user set mdp=? where id = ?  ");
        return $res->execute(array( $mdp, $id )) ;
    }

    // obtenir la listes des albums d'un utilisateurs
    public function listAlbums( $idUser ) {
        $res = $this->conn->prepare("Select * from album where iduser = ?  ");
        $res->execute(array( $idUser )) ;
        return $res;
    }

    public function insertAlbums( $nom, $affiche, $urlalbum, $idUser) {
        $res =  $this->conn->prepare(" INSERT into album (nom, affiche, urlalbum, iduser, date) values ( ?, ?, ?, ?, ? )");
        $date = date("m/d/y") ;
        return $res->execute( array( $nom, $affiche, $urlalbum, $idUser, $date  )) ;
    }


    // obtenir la liste des photos d'un albums
    public function listPhotosAlbum( $idAlbums) {
        $res = $this->conn->prepare("SELECT * from photo where idalbum =  ?  ");
        $res->execute(array( $idAlbums )) ;
        return $res;
    }

    // inseréer une nouvelle photo à un album
    public function insertPhoto( $nom, $photo, $idAlbum ) {
        $res =  $this->conn->prepare(" INSERT into photo (nom, image, idalbum) values ( ?, ?, ? )");
        $date = date("m/d/y") ;
        return $res->execute( array( $nom, $photo, $idAlbum  )) ;
    }

    // modification des photos à afficher
    public function modificationAffichePhoto( $affiche, $idalbum ) { 
        $res = $this->conn->prepare("Update album set affiche=?  where id = ?  ");
        return $res->execute(array( $affiche, $idalbum )) ;
    }

    // obtenir le details d'un album par son url
    public function detialsAlbumUrl( $url ){
        $res = $this->conn->prepare("SELECT * from album where urlalbum = ? ");
        $res->execute(array( $url )) ;
        return $res->fetch();
    }
    
    // suprimer une photo par son id
    public function deletePhoto( $idPhoto ) {
        $res =  $this->conn->prepare(" DELETE FROM photo WHERE  id = ? ; ");
        return $res->execute( array( $idPhoto )) ;
    }

    


}
