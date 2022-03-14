<?php

require "./vendor/autoload.php"; 

// chargement de flight 
$loader = new \Twig\Loader\FilesystemLoader(dirname(__FILE__) . '/views');
$twigConfig = array(
    // 'cache' => './cache/twig/',
    // 'cache' => false,
    'debug' => true,
);

Flight::register('view', '\Twig\Environment', array($loader, $twigConfig), function ($twig) {
    $twig->addExtension(new \Twig\Extension\DebugExtension()); // Add the debug extension
});



/* 
    Gestio des routages
*/

// page d'acceuil
Flight::route('/~aescuder', function(){
    Flight::view()->display('index.twig');
});

// requete non fondées alors redirection vers page d'acceuil
Flight::map('notFound', function(){
    Flight::view()->display('index.twig');
});

// affichage d'un album pour les autres utilsiateurs
Flight::route('/afficheAlbum/@urlAlbum', function($urlAlbum){
    $bdd = new Bdd;
    $Module = $bdd->detialsAlbumUrl( $urlAlbum );
    if($Module['affiche'] != 0){
        $album = new Album( $Module['id'], $Module['nom'], $Module['affiche'], $Module['urlalbum'], $Module['iduser'], $Module['date']) ;
        $album->miseAjoursPhoto( $bdd );
        $url = "http://$_SERVER[HTTP_HOST]/afficheAlbum/".$album->getUrl();
        $data = [
            'album' => $album,   
            'url' => $url
        ];
        Flight::view()->display('albumPartage.twig', $data);
    }else {
        Flight::view()->display('albumPartageInexsitant.twig');
    } 
});

// déconnection et redirection vers la page d'accueil
Flight::route('/deconnection', function(){
    deconnection();
    Flight::view()->display('index.twig');
});


function testConnection(){
    session_start(); 
    if( isset($_SESSION['user'])){
        $res = $_SESSION['user'];
        $data = [ 'user' => $res,  ];
        return $data;
    }else {
        return false;
    }
    
}
// connection d'un utilisateurs
Flight::route('/~aescuder/connection', function(){
    $res = testConnection();
    if( $res != false  ){ 
        Flight::view()->display('acceuilConnection.twig', $res );
    }else {
        Flight::view()->display('connection.twig');
    }
    
});

// inscription d'un utilsiateurs
Flight::route('/inscription', function(){
    $res = testConnection();
    if( $res != false  ){ 
        Flight::view()->display('acceuilConnection.twig', $res );
    }else {
        Flight::view()->display('inscription.twig');
    }   
});


// page d'acceuil d'un utilisateur connectées
Flight::route('/acceuilConnection', function(){
    $res = testConnection();
    if( $res != false  ){ 
        Flight::view()->display('acceuilConnection.twig', $res );
    }else {
        Flight::view()->display('connection.twig');
    }  
});


// page détaillant le contenue d'un album au utilisateurs et permmetant de le gerer 
Flight::route('/detailsAlbum/@idalbum', function($idalbum){
    session_start();  $bdd = new Bdd;
    
    if( isset($_SESSION['user'])){
        $user =  $_SESSION['user'];
        foreach($_SESSION['user']->getAlbums() as $val) {
            if($idalbum == $val->getId() ){
                $albumDetails = $val;
            }
        }
        $url = "http://$_SERVER[HTTP_HOST]/afficheAlbum/".$albumDetails->getUrl();
       
        $data = [
            'user' => $user,
            'album' => $albumDetails,
            'url' => $url
        ];
    
        Flight::view()->display('detailsAlbum.twig', $data);
    }else {
        header('Location: ./connection');  exit();
    }

});



// démarrage de flight pour le routage
Flight::start();




