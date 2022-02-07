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
    $testReponse = 'ok';
    
    $testReponse = $data->photo;
    
    $bdd->insertPhoto( "lll", $data->photo, $data->album ) ;
    $_SESSION['user']->miseAjoursAlbums( $bdd );
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
