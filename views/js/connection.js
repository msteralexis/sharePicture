
function erreurValue( input, messageErreur ) {
    input.style.backgroundColor='red' 
    input.value ='';
    input.placeholder =  messageErreur ;
}



function controlConnection( mail, mdp) {

     
    const newUser = {
        type: 'connectionUtilisateurs',
        mail: mail.value,
        mdp : mdp.value
    }

    const requeteInscription = fetch("../../src/controller/connectionInscription.php", {
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

	var body = document.body;


    var bouttonConnection = document.querySelector('#bouttonConnection');

	bouttonConnection.addEventListener('click', function() {

        var mail = document.querySelector('#mail')
        var mdp = document.querySelector('#mdp')

        controlConnection( mail, mdp)
   
	});


}
