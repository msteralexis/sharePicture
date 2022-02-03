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


    public function insertUser($nom, $prenom, $mail, $mdp) {
        $mdp = md5( $mdp ); 
        $res =  $this->conn->prepare(" INSERT INTO user (nom, prenom, mail, mdp)  VALUES ( ?, ?, ?, ? )");
        return $res->execute( array( $nom, $prenom, $mail, $mdp )) ;
    }

    public function userExistantMail( $mail) {
        $res = $this->conn->prepare("Select * from user where mail = ?  ");
        $res->execute(array($mail )) ;
        return $res->fetch();
    }

    public function userExistantId( $id ) {
        $res = $this->conn->prepare("Select * from user where id = ?  ");
        $res->execute(array($id )) ;
        return $res->fetch();
    }

    public function userConnection( $mail, $mdp ) {
        $mdp = md5( $mdp ); 
        $res = $this->conn->prepare("Select * from user where mail = ? and mdp = ? ");
        $res->execute(array($mail, $mdp )) ;
        return $res->fetch();
    }

    public function modificationtUser( $nom, $prenom, $mail, $id ) { 
        $res = $this->conn->prepare("Update user set nom=?, prenom=?, mail=? where id = ?  ");
        return $res->execute(array($nom, $prenom, $mail, $id )) ;
    }

    public function modificationtMDPUser( $mdp, $id ) { 
        $mdp = md5($mdp);
        $res = $this->conn->prepare("Update user set mdp=? where id = ?  ");
        return $res->execute(array( $mdp, $id )) ;
    }

    public function listAlbums( $idUser ) {
        $res = $this->conn->prepare("Select * from album where iduser = ?  ");
        $res->execute(array( $idUser )) ;
        return $res;
    }

    public function insertAlbums( $nom, $affiche, $urlalbum, $idUser) {
        $res =  $this->conn->prepare(" INSERT into album (nom, affiche, urlalbum, iduser) values ( ?, ?, ?, ? )");
        return $res->execute( array( $nom, $affiche, $urlalbum, $idUser )) ;
    }

    public function listPhotosAlbum( $idAlbums) {
        $res = $this->conn->prepare("SELECT photo.* from,albumphoto photo where photo.id = albumphoto.photo and albumphoto.album =  ?  ");
        $res->execute(array( $idAlbums )) ;
        return $res;
    }



    /*
    
    // Vérification de la connection d'un utilisateur (avec le login et mot de passe qu'il a renseigner)
    public function connection($mail, $password) {
        $pasword = md5( $password ); 
        $res = $this->conn->prepare("Select * from user where mail = ? and password = ? ");
        $res->execute(array($mail, $pasword)) ;
        return $res->fetch();
    }
 
    

    // Insertion dans les différantes tables
    public function insertenseignant($nom,$prenom, $mail, $telephone, $universite) {
        $res =  $this->conn->prepare(" INSERT INTO enseignant (nom, prenom, mail,  telephone, universite)  VALUES ( ?, ?, ?, ?, ?)");
        return $res->execute( array( $nom,$prenom, $mail, $telephone, $universite )) ;
    }

    public function insertUniversite($nom,$ville, $adresse) {
        $res =  $this->conn->prepare(" INSERT INTO universite (nom, ville, adresse)  VALUES ( ?, ?, ?)");
        return $res->execute( array( $nom,$ville, $adresse )) ;
    }

    public function  insertModule($nom,$niveau, $domaineModule, $datefinModule, $miseneligneModule  , $statutModule, $datedebutModule, $niveauannne ) {
        $res =  $this->conn->prepare(" INSERT INTO module (nom, niveau, datedebut, datefin, statut, miseenligne, domaine, niveauanne)  VALUES ( ?, ?,?,?,?,?,?,?)");
        return $res->execute( array( $nom,$niveau, $datedebutModule, $datefinModule, $statutModule,$miseneligneModule, $domaineModule,     $niveauannne )) ;
    }

   

    public function insertGestionaireModule($idEnseignant,$idModule) {
        $res =  $this->conn->prepare(" INSERT INTO suivi (enseignant, module)  VALUES ( ?, ? )");
        return $res->execute( array( $idEnseignant, $idModule )) ;
    }

    // Modification des différentes tables
    public function modificationenseignant($nom,$prenom, $mail, $telephone, $universite, $id) { 
        $res = $this->conn->prepare("Update enseignant set nom=?, prenom=?, telephone=?, universite=?,  mail = ?   where identifiant = ?  ");
        return $res->execute(array($nom, $prenom, $telephone, $universite, $mail, $id)) ;
    }
    
    public function modificationUniversite($nom, $ville, $adresse, $id) { 
        $res = $this->conn->prepare("Update universite set nom=?, ville=?, adresse=?   where identifiant = ?  ");
        return $res->execute(array($nom, $ville, $adresse, $id)) ;
    }

    public function modificationUser($nom,$prenom, $mail,  $id) { 
        $res = $this->conn->prepare("Update user set nom=?, prenom=?, mail = ?   where identifiant = ?  ");
        return $res->execute(array($nom, $prenom,$mail, $id)) ;
    }

    public function modificationPasswordUser($password,  $id) { 
        $password = md5( $password );
        $res = $this->conn->prepare("Update user set password=?  where identifiant = ?  ");
        return $res->execute(array($password, $id)) ;
    }
    
    public function modificationModule( $nom,$niveau, $domaineModule, $datefinModule, $miseneligneModule  , $statutModule, $datedebutModule, $identifiant, $niveauannne ) {
        $res = $this->conn->prepare("Update module set nom=?, niveau=?, datedebut=?, datefin=?, statut=?, miseenligne=?, domaine=?, niveauanne=? where identifiant=?  ");
        return $res->execute( array( $nom,$niveau, $datedebutModule, $datefinModule, $statutModule, $miseneligneModule, $domaineModule, $niveauannne, $identifiant )) ;
    }


    // Obtenir le details d'une table en reseignant le nom de la table et sont identifiant
    public function details($nomTable, $identifiant) { 
        $res = $this->conn->prepare("Select * from $nomTable where identifiant = $identifiant ");
        $res->execute() ;
        return $res->fetch();
    }

    // Obtenir tous les lignes d'une table en passant sont nom en paramètre.
    public function list($nom) { 
        $res = $this->conn->prepare("Select * from $nom");
        $res->execute() ;
        return $res;
    }

    // Obtenir la liste de tous les professeurs s'occupant d'un module par sont
    public function detailsModule( $identifiant) { 
        $res = $this->conn->prepare("select enseignant.* from enseignant, suivi where  suivi.enseignant=enseignant.identifiant and suivi.module = $identifiant ");
        $res->execute() ;
        return $res;
    }


    public function deleteGestionaireModule( $idEnseignant ){
        $res =  $this->conn->prepare(" delete from suivi where enseignant = ?");
        return $res->execute( array( $idEnseignant )) ;

    }


    // Obtenir la liste de tous les enseignant qui ne sont pas gestionaire d'un module
    public function listEnseignantSansModule( $identifiant ) { 
        $res = $this->conn->prepare("SELECT * FROM enseignant where enseignant.identifiant not in (select suivi.enseignant from suivi where suivi.module = $identifiant )  ");
        $res->execute() ;
        return $res;
    }

    // obtenir la liste des tous les modules en fonction d'un certain nombre de critère
    public function listModulesFiltres($statut, $miseenligne , $niveau , $moduleAvecEnseignant) {

        $requestCritere = ' ';
        $champs = array();
        $requestCritere .=   "  where statut = ?"; $champs[] = $statut;
        $requestCritere .=   "  and miseenligne = ?";  $champs[] = $miseenligne;
        $requestCritere .=   "  and niveau = ?";  $champs[] = $niveau;

        if ( $moduleAvecEnseignant == 0) {
            $requestCritere .=   " and module.identifiant  in (select suivi.module from suivi )";
        }else{
            $requestCritere .=   " and module.identifiant not in (select suivi.module from suivi )";
        }
        $res = $this->conn->prepare(" SELECT * FROM module  $requestCritere ORDER BY nom ASC");
        $res->execute($champs);
        return $res;
    }




    public function deleteElement($nomTable, $identifiant) { 
        $res = $this->conn->prepare(" DELETE FROM $nomTable WHERE identifiant = $identifiant  ");
        return $res->execute() ;
    }

    

    public function deleteEnseignantGestionaire( $identifiantModule ) { 
        $res = $this->conn->prepare(" DELETE FROM suivi  WHERE module = $identifiantModule  ");
        return $res->execute() ;
    }

    public function deleteEnseignantGestionaireEnseignant( $identifiantEnseignant ) { 
        $res = $this->conn->prepare(" DELETE FROM suivi  WHERE enseignant = $identifiantEnseignant  ");
        return $res->execute() ;
    }

    
    */











}
