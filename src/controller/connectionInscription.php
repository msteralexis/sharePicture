<?php

require "../../vendor/autoload.php"; 


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


// vérification des données d'inscription d'un utilsiateurs
function verificationDonnerUser( $nom, $mail, $prenom){
    if( strlen($nom) < 3 || strlen($nom) > 30  ){ return "Erreur sur le nom" ;}
    if( strlen($prenom) < 3 || strlen($prenom) > 30  ){ return "Erreur sur le prenom" ;}
    if(! preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-.]?[[:alnum:]])*\.([a-z]{2,4})$`', $mail )) {return "Erreur sur le mail" ;}
    return  "Succès";
}

// reception requete pour enregistrer un User
if( $data->type == 'ajoutsUtilisateurs' ) {
    $bdd = new Bdd;
    $testReponse = verificationDonnerUser( $data->nom, $data->mail, $data->prenom , $data->mdp);
    if( $testReponse  == "Succès"  ){
        if(! $bdd->userExistantMail( $data->mail) ) {
            if(  $bdd->insertUser( $data->nom, $data->prenom, $data->mail, $data->mdp ) ) {   
                $testReponse = "ajouter"; 
            }
        }  
    }  
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}



// reception requete pour connection d'un User
if( $data->type == 'connectionUtilisateurs' ) {  
    $bdd = new Bdd; $testReponse = "inexistant";     
    if( $result = $bdd->userConnection( $data->mail, $data->mdp )  ) { // on vérifie que l'utilisateur existe

        // on s'assure de la deconnection de l'utilisateurs
        deconnection(); session_start(); 

        // creation de l'objets User stockan les informations de l'utilsiateurs
        $user = new User($result['id'],$result['nom'], $result['prenom'], $result['mail']);  
        $user->miseAjoursAlbums( $bdd ); // obtenir la liste de tous les albums de l'user
        $_SESSION['user'] = $user; // transmettre toutes les informations user à la variable de sessions
        
        $testReponse = "connecte";   
    }
        
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}


