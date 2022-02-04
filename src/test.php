<?php 


require "../vendor/autoload.php"; 

$a = substr(sha1(mt_rand()),17,50);
var_dump($a);

$m = date("m/d/y"); 
var_dump($m);




$bdd = new Bdd;

session_start(); 

$c = $_SESSION['user'];

$data = [
    'user' => $c,
];

//var_dump($data['user']);





// Liste albums selon id utilisateurs connectées
 

    // Affichage liste albums
    foreach ( $data['user']->getAlbums() as &$value) {
        var_dump( $value->getNom() ) ;
    }

    var_dump($_SESSION['user']->getNom() );

    $_SESSION['user']->setNom( 'toto');
    var_dump($_SESSION['user']->getNom() );



/*
    $c = $bdd->listPhotosAlbum( 1 );
    $listModulesTab = array();
    while($module = $c->fetch() ){
      var_dump($module);
        $listModulesTab[] = $module;
    }
    
*/

  







/* stock de photo 
$nom = "toto"; // Le nom du répertoire à créer

// Vérifie si le répertoire existe :
if (is_dir($nom)) {
                  echo 'Le répertoire existe déjà!';  
                  }
// Création du nouveau répertoire
else { 
      mkdir($nom);
      echo 'Le répertoire '.$nom.' vient d\'être créé!';      
      }
*/