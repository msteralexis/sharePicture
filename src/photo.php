<?php

class Photo {
    // information connection bdd
    protected  $id = ' ';
    protected  $nom = ' ';
    protected  $image = ' ';
    protected $idalbum = ' ';




    // Constructeur
    public function __construct($id, $nom, $image, $idalbum) {
        $this->id = $id;
        $this->nom = $nom; 
        $this->image = $image; 
        $this->idalbum = $idalbum; 
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getImage(){
        return $this->image;
    }

    public function getIdalbum(){
        return $this->idalbum;
    }


    public function setId($id){
        $this->id = $id;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setImage($image){
        $this->image = $image;
    }









}
