<?php

class Album {

    // Information connection bdd
    protected $id = 0;
    protected $nom = '';
    protected $affiche = 0;
    protected $url = ' ';
    protected $idUser = 0;
    protected $date = '';
    protected $photo = array();




    // Constructeur
    public function __construct($id, $nom, $affiche, $url, $idUser, $date) {
        $this->id = $id;
        $this->nom = $nom;
        $this->affiche = $affiche;
        $this->url = $url;     
        $this->idUser = $idUser; 
        $this->date = $date;  
    }



    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getAffiche(){
        return $this->affiche;
    }

    public function getUrl(){
        return $this->url;
    }


    public function getIdUser(){
        return $this->idUser;
    }

    public function getDate(){
        return $this->date;
    }

    public function getPhoto(){
        return $this->photo;
    }

    



    public function setNom( $nom ){
        $this->nom = $nom;
    }

    public function setAffiche( $affiche ){
        $this->affiche = $affiche;
    }

    public function setUrl( $url ){
        $this->url = $url;
    }

    public function setPhoto( $listPhotos){
        $this->photo = $listPhotos;
    }


    public function miseAjoursPhoto( $bdd ){
        $c = $bdd->listPhotosAlbum( $this->getId() );
        
        $listModulesTab = array();
        while($Module = $c->fetch() ){
            $a = new Photo( $Module['id'], $Module['nom'], $Module['image'], $Module['idalbum'] ) ;
            $listModulesTab[] = $a;
        }
        $this->setPhoto( $listModulesTab );
    }


   

 




}
