<?php

require "../../vendor/autoload.php"; 

session_start(); 
/*
Reception requete ajax.  
*/
$json = file_get_contents('php://input');
$data = json_decode($json); // Converts it into a PHP object



// valeur retour sous forme json
function jsonRetour( $valeurRetour) {
    header('Content-Type: application/json');
    echo json_encode( $valeurRetour, JSON_PRETTY_PRINT);
}


if( $data->type == 'ajoutphoto' ) {
    $bdd = new Bdd;
    
    
   
    if( strlen($data->photo) < 65000){
        $bdd->insertPhoto( "lll", $data->photo, $data->album ) ;
        $_SESSION['user']->miseAjoursAlbums( $bdd );
        $testReponse = $data->photo;
    }else{
        $testReponse = 'fichier trops volumineux';   
    }
    
   
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}


if( $data->type == 'affichealbum' ) {
    $bdd = new Bdd;
    $testReponse = 'erreur';
    if( $data->affiche == 'true' ){
        $affiche = 1;
    }else{
        $affiche = 0;
    }
    
    if($bdd->modificationAffichePhoto( $affiche , $data->album ) ){

        $_SESSION['user']->miseAjoursAlbums( $bdd );
        $testReponse = 'ok';

    }
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}


if( $data->type == 'suppressionphoto' ) {
    $bdd = new Bdd;
    $testReponse = 'erreur';

    
    if($bdd->deletePhoto(  $data->idphoto )  ){

        $_SESSION['user']->miseAjoursAlbums( $bdd );
        $testReponse = 'ok';

    }
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}
