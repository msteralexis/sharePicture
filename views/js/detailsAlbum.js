
function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;
    
    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
  
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
  
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Fallback: Copying text command was ' + msg);
    } catch (err) {
      console.error('Fallback: Oops, unable to copy', err);
    }
  
    document.body.removeChild(textArea);
  }

function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
      fallbackCopyTextToClipboard(text);
      return;
    }
    navigator.clipboard.writeText(text).then(function() {
        alert("le texte à été copier")
        }, function(err) {
        alert('Erreur dans la copie: ', err);
    });
}























// Constitution d'une requete
function compositionRequete( objetRequete  ) { 
    return fetch("/src/controller/detailsAlbums.php", {
            method: "POST",
            headers: { 
            'Content-Type': 'application/json',
        },
        body: JSON.stringify( objetRequete  )
    });
}


// lancement de la requete et traitement standart de la réponse
function  requetageReponse( requete ){
    requete.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(jsons) {
            });
        }
    });
}



function requestAjoutsPhoto(result, album, listAlbum){
    // Constitution d'un objets pour passage en paramètre
    const objetRequete = {
        type: 'ajoutphoto',
        photo: result,
        album : album.value      
    }

    // constitution de la requete
    const requete = compositionRequete( objetRequete )
    
    // lancement requete et analyse réception
    requete.then(async( response) =>{ 
        console.log(response)
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(jsons) {

                // analyse retours lors d'un enregistrement d'image
                if( objetRequete.type == 'ajoutphoto') {
                    if(jsons =='fichier trops volumineux'){
                        alert(jsons)
                    } else {
                        var t = new Image(200, 200)
                        t.src = result
                        listAlbum.appendChild(t);
                    }
                }    
            });
        }
    });
}





// Requete pour permettant de publier l'album au public ou l'annuller
function requestAfficheAlbum(result, album ){
    // Constitution d'un objets pour passage en paramètre
    const objetRequete  = {
        type: 'affichealbum',
        affiche: result,
        album : album.value  
    }

    // constitution de la requete
    const requete = compositionRequete( objetRequete ) 
    requetageReponse( requete )
}



function requestSuppressionPhoto( idPhoto ){
    // Constitution d'un objets pour passage en paramètre
    const objetRequete = {
        type: 'suppressionphoto',
        idphoto: idPhoto,
    }

    // constitution de la requete
    const requete = compositionRequete( objetRequete )
    requetageReponse( requete )   
}







// Début du programme 
onload = function() {

    var idAlbum = document.querySelector('#idAlbum'); // stockage de l'id de lalbum pour les requete
    var listAlbum = document.querySelector('#listAlbum'); // liste des photos de l'albums 



     // Etude des click sur les croix des photo permettant de les suprimer.
     var li = document.querySelectorAll('.suprime');
     for(var i = 0;i<li.length;i++){
         li[i].addEventListener("click", supresionPhoto );
     }
 
     function supresionPhoto (e){
         // id de l'image à suprimer
         requestSuppressionPhoto( e.target.attributes.value.value )
 
         // supression element du dom
         var elementParent = e.target.parentNode
         elementParent.remove( );
     }

    // Changement de l'affichage de l'album au public ou non 
    var affiche = document.querySelector('#boutonGliserDeposer');
        affiche.addEventListener('click', function() {
        requestAfficheAlbum( this.checked  , idAlbum )
    });




    // copier coller de l'url (chargemet de l'url dans le press papier)
    var clickUrl = document.querySelector('#copierUrl');  
    clickUrl.addEventListener('click', function() {
        copyTextToClipboard( this.parentNode.firstChild.nodeValue )
    });
    

    

    
   


    var inputPhoto = document.querySelector('#inputPhoto');

    inputPhoto.addEventListener('change', ajoutsPhotoDrop );
    function ajoutsPhotoDrop(){
        
        // chargement d'un fichier
        var r = new FileReader(); // Création d'un FileReader pour lire le fichier    
        r.readAsDataURL ( this.files[0] ) 
        r.onload = function() { // En réaction à la fin de la lecture du fichier par le FileReader :
            requestAjoutsPhoto( this.result, idAlbum, listAlbum)
     
        }
     }



    // chargement de la zone de drop 
    var drp = document.querySelector('#drop');
    
    drp.ondragover = function(evt) {
        evt.preventDefault(); // Désactive le comportement par défaut du navigateur (indispensable)
        evt.dataTransfer.dropEffect = 'copy'; // Spécifie l'effet au survol de ce dropable
    }

    // lancement lecture lors d'un drop
    drp.ondrop = function(evt) {
        evt.preventDefault(); // Désactive le comportement par défaut du navigateur

        // chargement d'un fichier
        var r = new FileReader(); // Création d'un FileReader pour lire le fichier    
        r.readAsDataURL ( evt.dataTransfer.files[0] ) 
        r.onload = function() { // En réaction à la fin de la lecture du fichier par le FileReader :
            requestAjoutsPhoto( this.result, idAlbum, listAlbum)
        }  
    }


 

    

}

       













    
