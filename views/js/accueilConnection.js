function miseANiveauCouleurInput( nom, prenom, mail) {
    nom.style.backgroundColor='white' 
    prenom.style.backgroundColor='white' 
    mail.style.backgroundColor='white' 
}

function erreurValue( input, messageErreur ) {
    input.style.backgroundColor='red' 
    input.value ='';
    input.placeholder =  messageErreur ;
}


function modificationtUtilisateur( nom, prenom, mail,  id) { 
    const newUser = {
        type: 'modificationtUtilisateur',
        nom: nom.value,
        prenom:prenom.value,
        mail: mail.value,
        id: id.value
    }

    requeteModificationDonneesUsers( newUser)
}

function requeteModificationDonneesUsers( newUser) {
    const requeteInscription = fetch("./src/controller/acceuilConnection.php", {
        method: "POST",
        headers: { 
    'Content-Type': 'application/json',
    },
        body: JSON.stringify( newUser)
    });

    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(json) {
                if(json =='ajouter'){
                    alert("Element modifier")
                }
            });
        }
    });

}




function controlSaisi( nom, prenom, mail,  id) {

    miseANiveauCouleurInput( nom, prenom, mail)
    compteurError = 0
    if( nom.value.length < 3) {  compteurError = 1 ; erreurValue( nom, " 3 caratères minimun" ) }
    if( prenom.value.length < 3) { compteurError = 1 ; erreurValue( prenom, " 3 caratères minimun") }
 
    if (! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( mail.value )) { compteurError = 1 ; erreurValue( mail, "mail incorrecte" ) }
 
    if( compteurError == 0){  modificationtUtilisateur( nom, prenom, mail, id)  }
  
}
  


function modificationtUtilisateurMDP( mdp1, mdp2, id) { 
 
    const newUser = {
        type: 'modificationtUtilisateurMDOP',
        mdp1: mdp1.value,
        mdp2 : mdp2.value,
        id: id.value
    }

    const requeteInscription = fetch("./src/controller/acceuilConnection.php", {
            method: "POST",
            headers: { 
            'Content-Type': 'application/json',
        },
            body: JSON.stringify( newUser)
        });
    
    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
    if(contentType && contentType.indexOf("application/json") !== -1) {
        return response.json().then(function(json) {
            if(json =='ajouter'){
                window.location.replace("/acceuilConnection");
            }
        });
    }

    });
 
}

function controlModificationMDP( mdp1, mdp2, id ) {
    mdp1.style.backgroundColor='white' 
    mdp2.style.backgroundColor='white' 
       
    compteurError = 0
    if( mdp1.value.length < 3) {  compteurError = 1 ; erreurValue( mdp1, " 3 caratères minimun" ) }
    if( mdp1.value != mdp2.value) { compteurError = 1 ; erreurValue( mdp1, " mot de passe différents" ) }
    
    if( compteurError == 0){  modificationtUtilisateurMDP( mdp1, mdp2, id)   }   
}


function ajoutAlbum( nom, iduser) { 
 
    const newUser = {
        type: 'ajoutalbum',
        nomalbum: nom.value,
        iduser : iduser.value
    }

    const requeteInscription = fetch("./src/controller/acceuilConnection.php", {
            method: "POST",
            headers: { 
            'Content-Type': 'application/json',
        },
            body: JSON.stringify( newUser)
        });
    
    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
    if(contentType && contentType.indexOf("application/json") !== -1) {
        return response.json().then(function(jsons) {

            var listAlbums = document.querySelector('#listAlbums');

            retourAlbum = JSON.parse(jsons)
            listAlbums.innerHTML = listAlbums.innerHTML + '<article>  <a href="./detailsAlbum/ '+ retourAlbum.id +' \"> ' +retourAlbum.id + '  ' +retourAlbum.nom + ' ' +retourAlbum.affiche + '  ' + retourAlbum.date + '  </a>  </article> '
           
           
         
        });
    }

    });
 
}

onload = function() {

	var body = document.body;
    var bouttonInscription = document.querySelector('#bouttonModification');
    var bouttonModificationMDP = document.querySelector('#bouttonModificationMDP');
    var bouttonAjoutsAlbum = document.querySelector('#bouttonAjoutsAlbum');

	bouttonInscription.addEventListener('click', function() {	  
        var nom = document.querySelector('#nom')
        var prenom = document.querySelector('#prenom')
        var mail = document.querySelector('#mail')
        var id =  document.querySelector('#idUser')
        controlSaisi( nom, prenom, mail, id)
	});
   
    bouttonModificationMDP.addEventListener('click', function() {
        var mdp1 = document.querySelector('#mdp1')
        var mdp2 = document.querySelector('#mdp2')
        var id =  document.querySelector('#idUser')

        controlModificationMDP( mdp1, mdp2, id )
	});


    

    bouttonAjoutsAlbum.addEventListener('click', function() {
        var nomAlbum = document.querySelector('#nomAlbum')
        var idUser = document.querySelector('#idUser')
        ajoutAlbum( nomAlbum, idUser) 
    
	});


    

}
