// mise a zero des fond de couleurs
function miseANiveauCouleurInput( nom, prenom, mail, mdp) {
    nom.style.backgroundColor='white' 
    prenom.style.backgroundColor='white' 
    mail.style.backgroundColor='white' 
    mdp.style.backgroundColor='white' 
}

// Modification des Inputs comportant une erreurs de sasies.
function erreurValue( input, messageErreur ) {
    input.style.backgroundColor='red' 
    input.value ='';
    input.placeholder =  messageErreur ;
}


function enregistrementUtilisateur( nom, prenom, mail, mdp) { 
 
    // création de l'objets utilsiateurs
    const newUser = {
        type: 'ajoutsUtilisateurs',
        nom: nom.value,
        prenom:prenom.value,
        mail: mail.value,
        mdp : mdp.value
    }

    requeteInscriptionUsers( newUser )
}

function requeteInscriptionUsers( newUser ){
    // requetes.
    const requeteInscription = fetch("/src/controller/connectionInscription.php", {
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
                    window.location.replace("/connection");
                }
            });
        }
    });

}


function controlSaisi( nom, prenom, mail, mdp) {

    miseANiveauCouleurInput( nom, prenom, mail, mdp) // remise à niveaux des inputs
    compteurError = 0
    if( nom.value.length < 3) {  compteurError = 1 ; erreurValue( nom, " 3 caratères minimun" ) }
    if( prenom.value.length < 3) { compteurError = 1 ; erreurValue( prenom, " 3 caratères minimun") }
 
    if (! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( mail.value )) { compteurError = 1 ; erreurValue( mail, "mail incorrecte" ) }
 
    if( mdp.value.length < 3) { compteurError = 1 ; erreurValue( mdp, " 3 caratères minimun" ) }
    
    // si aucune erreurs alors enregistrement de l'utilisateurs
    if( compteurError == 0){ enregistrementUtilisateur( nom, prenom, mail, mdp) }
  
}
  


onload = function() {
	var body = document.body;
    var bouttonInscription = document.querySelector('#bouttonInscription');

	bouttonInscription.addEventListener('click', function() {
		  
        var nom = document.querySelector('#nom')
        var prenom = document.querySelector('#prenom')
        var mail = document.querySelector('#mail')
        var mdp = document.querySelector('#mdp')

        controlSaisi( nom, prenom, mail, mdp)
	});

}
