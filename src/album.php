<?php

class Album {

    // Information connection bdd
    protected $id = 0;
    protected $nom = '';
    protected $affiche = 0;
    protected $url = ' ';
    protected $idUser = 0;



    // Constructeur
    public function __construct($id, $nom, $affiche, $url, $idUser) {
        $this->id = $id;
        $this->nom = $nom;
        $this->affiche = $affiche;
        $this->url = $url;     
        $this->idUser = $idUser;   
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



    public function setNom( $nom ){
        return $this->nom;
    }

    public function setAffiche( $affiche ){
        return $this->affiche;
    }

    public function setUrl( $url ){
        return $this->url;
    }


   

 




}
