<?php

class User {

    // Information connection bdd
    protected $id = 0;
    protected $nom = 'toto';
    protected $prenom = 'titi';
    protected $mail = ' ';
    protected $mdp = '';
    protected $albums = array();

   

    // Constructeur
    public function __construct($id, $nom, $prenom, $mail) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;      
    }



    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getMail(){
        return $this->mail;
    }

    public function getAlbums(){
        return $this->albums;
    }




    public function setNom( $nom ){
        $this->nom = $nom;
    }

    public function setPrenom( $prenom ){
        $this->prenom = $prenom;
    }

    public function setMail( $mail ){
        $this->mail = $mail ;
    }

    public function setAlbums( $albums ){
        $this->albums = $albums;
    }

    public function miseAjoursAlbums( $bdd ){
        $c = $bdd->listAlbums( $this->getId() );
        
        $listModulesTab = array();
        while($Module = $c->fetch() ){
            $a = new Album( $Module['id'], $Module['nom'], $Module['affiche'], $Module['urlalbum'], $Module['iduser'], $Module['date']) ;
            $a->miseAjoursPhoto( $bdd );
            $listModulesTab[] = $a;
        }
        $this->setAlbums( $listModulesTab);
    }


   

 




}
