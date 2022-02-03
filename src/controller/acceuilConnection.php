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


function verificationDonnerUser( $nom, $mail, $prenom){
    if( strlen($nom) < 3 || strlen($nom) > 30  ){ return "Erreur sur le nom" ;}
    if( strlen($prenom) < 3 || strlen($prenom) > 30  ){ return "Erreur sur le prenom" ;}
    if(! preg_match('`^[[:alnum:]]([-_.]?[[:alnum:]])*@[[:alnum:]]([-.]?[[:alnum:]])*\.([a-z]{2,4})$`', $mail )) {return "Erreur sur le mail" ;}
    return  "Succes";
}


// reception requete pour Modifier un User
if( $data->type == 'modificationtUtilisateur' ) {
    $bdd = new Bdd;
    $testReponse = verificationDonnerUser( $data->nom, $data->mail, $data->prenom );
    if( $testReponse  == "Succes"  ){
        if( $bdd->userExistantId( $data->id) ) { // vérification de l'existant de l'user en bdd
            if(  $bdd->modificationtUser( $data->nom, $data->prenom, $data->mail, $data->id) ) {    // modification des données en BDD
                // modification des données dans la variable de sessions
                $_SESSION['user']->setNom(  $data->nom );
                $_SESSION['user']->setPrenom(  $data->prenom );
                $_SESSION['user']->setMail(  $data->mail );   
                $testReponse = "ajouter"; 
            }
        }  
    }  
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}




function verificationMDPUser( $mdp1, $mdp2, $id ){
    return  "Succes";
}

if( $data->type == 'modificationtUtilisateurMDOP' ) {
    $bdd = new Bdd;
    $testReponse = verificationMDPUser( $data->mdp1, $data->mdp2, $data->id );
    if( $testReponse  == "Succes"  ){
        if( $bdd->userExistantId( $data->id) ) {
            if(  $bdd->modificationtMDPUser( $data->mdp1, $data->id ) ) {   
                $testReponse = "ajouter"; 
            }
        }  
    }  
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}




if( $data->type == 'ajoutalbum' ) {
    $bdd = new Bdd;
    if( $bdd->userExistantId( $data->iduser) ) {
        $urlalbum = substr(sha1(mt_rand()),17,6);
        if(  $Module = $bdd->insertAlbums( $data->nomalbum, 0, $urlalbum, $data->iduser ) ) { 
            $_SESSION['user']->miseAjoursAlbums( $bdd );
            $testReponse = "ajouter"; 
        }
    }  
    
    $bdd->closeConnection(); jsonRetour( $testReponse ); 
}


