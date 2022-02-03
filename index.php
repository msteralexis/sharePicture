<?php

require "vendor/autoload.php"; 

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
Flight::route('/', function(){
    Flight::view()->display('index.twig');
});

Flight::map('notFound', function(){
    Flight::view()->display('index.twig');
});



Flight::route('/deconnection', function(){
    deconnection();
    Flight::view()->display('index.twig');
});



Flight::route('/connection', function(){
    Flight::view()->display('connection.twig');
});



Flight::route('/acceuilConnection', function(){
    session_start(); 
    if( isset($_SESSION['user'])){
        $res = $_SESSION['user'];

        $data = [
            'user' => $res,
        ];

        Flight::view()->display('acceuilConnection.twig', $data );
    }else {
        header('Location: ./connection');  exit();
    }
});


Flight::route('/inscription', function(){
    Flight::view()->display('inscription.twig');
});


Flight::route('/detailsAlbum', function(){
    Flight::view()->display('detailsAlbum.twig');
});


// démarrage de flight pour le routage
Flight::start();




/* https://www.digitalocean.com/community/tutorials/how-to-use-the-mysql-blob-data-type-to-store-images-with-php-on-ubuntu-18-04-fr */
