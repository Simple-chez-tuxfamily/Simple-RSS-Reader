/*
 * Core.js
 * Les fonctions présentes dans ce fichier permettent d'effectuer une recherche des flux
*/

/*
 * Fonction qui s'occupe de créer une nouvelle instance XMLHttpRequest (et tout ce qui va avec)
*/
function getXMLHttpRequest(){
    var xhr = null;
    if(window.XMLHttpRequest || window.ActiveXObject){
	if(window.ActiveXObject){
	    try{
		xhr = new ActiveXObject("Msxml2.XMLHTTP");
	    }
	    catch(e){
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	}
        else
            xhr = new XMLHttpRequest();
    }
    else{
	afficher_message('Votre navigateur n\'est pas compatible avec Simple RSS Reader. Désolé.', 0, 0);
	return null;
    }
    return xhr;
}

/*
 * Fonction importante: permet de garder la session de l'utilisateur en vie
*/
function staying_alive(){
    var xhr = getXMLHttpRequest();
    xhr.open('GET', 'core/interact.php?action=stay_alive&token=[PHP_ADD_TOKEN]', true);
    xhr.send(null);
    setTimeout('staying_alive',  30000);
}
