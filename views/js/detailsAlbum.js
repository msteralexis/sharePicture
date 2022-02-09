

function requestAjoutsPhoto(result, album, listAlbum){


    const newPhoto = {
        type: 'ajoutphoto',
        photo: result,
        album : album.value
        
    }

    const requeteInscription = fetch("/src/controller/detailsAlbums.php", {
            method: "POST",
            headers: { 
            'Content-Type': 'application/json',
        },
        body: JSON.stringify( newPhoto )
    });
    
    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(jsons) {

                if(jsons =='fichier trops volumineux'){
                    alert(jsons)
                } else {
                    var t = new Image(600, 600)
                    t.src = result
                    listAlbum.appendChild(t);
                }
                
            });
        }
    });
    
}



function requestAfficheAlbum(result, album ){

    const newPhoto = {
        type: 'affichealbum',
        affiche: result,
        album : album.value
        
    }

    const requeteInscription = fetch("/src/controller/detailsAlbums.php", {
            method: "POST",
            headers: { 
            'Content-Type': 'application/json',
        },
        body: JSON.stringify( newPhoto )
    });
    
    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(jsons) {
               
            });
        }
    });
    
}



function requestSuppressionPhoto( idPhoto ){

    const newPhoto = {
        type: 'suppressionphoto',
        idphoto: idPhoto,
    }

    const requeteInscription = fetch("/src/controller/detailsAlbums.php", {
            method: "POST",
            headers: { 
            'Content-Type': 'application/json',
        },
        body: JSON.stringify( newPhoto )
    });
    
    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(jsons) {
               
            });
        }
    });
    
}

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


onload = function() {

   
    var d = document.body;
    var drp = document.querySelector('#drop');
    var listAlbum = document.querySelector('#listAlbum');

    var idAlbum = document.querySelector('#idAlbum');
    var affiche = document.querySelector('#demo5');

    var li = document.querySelectorAll('.suprime');

    var clickUrl = document.querySelector('#copierUrl'); 



    // etude des click sur les croix des photo permettant de les suprimer.
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












    var inputPhoto = document.querySelector('#inputPhoto');

    inputPhoto.addEventListener('change', doThing);


    function doThing(){
        
         // chargement d'un fichier
         var r = new FileReader(); // Création d'un FileReader pour lire le fichier    
         r.readAsDataURL ( this.files[0] ) 
         r.onload = function() { // En réaction à la fin de la lecture du fichier par le FileReader :
        
        
             requestAjoutsPhoto( this.result, idAlbum, listAlbum)
     
         }
     }









     
    


    
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


 

    // Changement de l'affichage de l'album au public ou non 
    affiche.addEventListener('click', function() {
        requestAfficheAlbum( this.checked  , idAlbum )
	});
    

    // chargemet de l'url dans le press papier
    clickUrl.addEventListener('click', function() {
        
        copyTextToClipboard( this.parentNode.firstChild.nodeValue )

	});
    





    drp.ondragenter = function(evt) {
        this.classList.add('effet'); // Ajout d'un style CSS au début du survol par le draggable
    }
        
    drp.ondragleave = function(evt) {
        this.classList.remove('effet'); // Retrait du style CSS en fin de survol par le draggable
    }




}

       


    