

function requestAjoutsPhoto(result, album, listAlbum){


    const newPhoto = {
        type: 'ajoutphoto',
        photo: result,
        album : album.value
        
    }

    const requeteInscription = fetch("http://0.0.0.0:8001/src/controller/detailsAlbums.php", {
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
               
                var t = new Image(600, 600)
                t.src = jsons
                listAlbum.appendChild(t);

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

    const requeteInscription = fetch("http://0.0.0.0:8001/src/controller/detailsAlbums.php", {
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



onload = function() {

   

var drp = document.querySelector('#drop');
var listAlbum = document.querySelector('#listAlbum');

var idAlbum = document.querySelector('#idAlbum');
var affiche = document.querySelector('#demo5');


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

    

    affiche.addEventListener('click', function() {
        console.log( this.checked );
        requestAfficheAlbum( this.checked  , idAlbum )

    
	});






    drp.ondragenter = function(evt) {
        this.classList.add('effet'); // Ajout d'un style CSS au début du survol par le draggable
    }
        
    drp.ondragleave = function(evt) {
        this.classList.remove('effet'); // Retrait du style CSS en fin de survol par le draggable
    }














































































    

}

       


    