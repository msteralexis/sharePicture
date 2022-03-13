// modification des element du dom pour signaler une erreur de saissie
function erreurValue( input, messageErreur ) {
    input.style.backgroundColor='red' 
    input.value ='';
    input.placeholder =  messageErreur ;
}


// Constitution d'une requete
function compositionRequete( objetRequete  ) { 
    return requeteInscription = fetch("/src/controller/connectionInscription.php", {
        method: "POST",
        headers: { 
        'Content-Type': 'application/json',
        },
        body: JSON.stringify( objetRequete  )
    });
}

function controlConnection( mail, mdp) {

     
    const objetRequete = {
        type: 'connectionUtilisateurs',
        mail: mail.value,
        mdp : mdp.value
    }

    const requeteInscription = compositionRequete( objetRequete  )
    
    requeteInscription.then(async( response) =>{ 
        var contentType = response.headers.get("content-type");
        if(contentType && contentType.indexOf("application/json") !== -1) {
            return response.json().then(function(json) {
                if(json =='connecte'){
                window.location.replace("/acceuilConnection");
                }else{
                    erreurValue( mail, " 3 caratères minimun" )
                    erreurValue( mdp, " 3 caratères minimun" )
                }
            });
        }
    });
}
  


onload = function() {

    var bouttonConnection = document.querySelector('#bouttonConnection');

	bouttonConnection.addEventListener('click', function() {
        var mail = document.querySelector('#mail')
        var mdp = document.querySelector('#mdp')

        controlConnection( mail, mdp)
	});

}
