<?php

class Photo {
    // information connection bdd
    protected  $id = ' ';
    protected  $nom = ' ';
    protected  $image = ' ';




    // Constructeur
    public function __construct($id, $nom, $image) {
        $this->id = $id;
        $this->nom = $nom; 
        $this->image = $image; 
    }










}
