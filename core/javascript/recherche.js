/*
 * Recherche.js
 * Les fonctions présentes dans ce fichier permettent d'effectuer une recherche des flux
*/

var ids_a_verifier;

/*
  * Fonction qui permet de récupérer les IDs des flux de l'utilisateur
*/
function liste_ids(){
    var xhr = getXMLHttpRequest();
    
    ids_a_verifier = null;
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {            
            ids_a_verifier = xhr.responseText.split(';');
            analyser_flux(0);
        }
        else{
            afficher_message('Impossible de lire la liste des flux à vérifier', 10, 0);
        }
    };
    
    xhr.open('GET', 'core/interact.php?action=get_feeds&token=[PHP_ADD_TOKEN]', true);
    xhr.send(null);
    
    return true;
}
/*
  * Fonction qui permet d'analyser une URL pour en récupérer les items
*/
function analyser_flux(position){
    var xhr = getXMLHttpRequest();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            masquer_message();
            masquer_loader();
            if(typeof ids_a_verifier[position + 1] != 'undefined')
                analyser_flux(position + 1);
            else
                nettoyer_base();
        }
    }
    
    flux_actuel = position + 1;
    afficher_message('Recherche en cours (' + flux_actuel + ' sur ' + ids_a_verifier.length + ')...', 0, 1);    
    document.getElementById('cover_all').style.display = 'block';
    afficher_loader();
    
    xhr.open('GET', 'core/interact.php?action=check&token=[PHP_ADD_TOKEN]&id=' + ids_a_verifier[position], true);
    xhr.send(null);
    
    return true;
}
/*
 * Fonction qui permet de lancer un nettoyage de la base de données
*/
function nettoyer_base(){
    var xhr = getXMLHttpRequest();
    
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4)
            location.reload();
        
    };
    
    afficher_message('Nettoyage de la base de données...', 0, 1);    
    document.getElementById('cover_all').style.display = 'block';
    afficher_loader();
    
    xhr.open('GET', 'core/interact.php?action=clean&token=[PHP_ADD_TOKEN]', true);
    xhr.send(null);
    
    return true;
}