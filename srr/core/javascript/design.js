/*
 * Design.js
 * Les fonctions présentes dans ce fichier permettent d'interagir avec le design
*/

/*
  * Fonction qui permet d'afficher le loader
*/
function afficher_loader(){
    if(document.getElementById('chargement'))
        document.getElementById('chargement').style.visibility = 'visible';
}
/*
  * Fonction qui permet de masquer le loader
*/
function masquer_loader(){
    if(document.getElementById('chargement'))
        document.getElementById('chargement').style.visibility = 'hidden';
}
/*
  * Fonction qui permet de changer le titre de la page
*/
function changer_titre(){
    document.title = '(' + items_non_lus + ') Flux non lus - Simple RSS Reader';
}
/*
  * Fonction qui permet de redimensionner les divs (liste des items, menu des paramètres et article) automatiquement toutes les 500ms
*/
function resize_divs(){
    var header_h = document.getElementsByTagName('header')[0].offsetHeight;
    
    if(document.getElementById('items'))
        document.getElementById('items').style.height = window.innerHeight - header_h + "px";
    
    if(document.getElementById('parametres'))
        document.getElementById('parametres').style.height = window.innerHeight - header_h + "px";
        
    if(document.getElementsByTagName('article')[0])
        document.getElementsByTagName('article')[0].style.maxHeight = window.innerHeight - header_h  + "px";
    
    setTimeout('resize_divs()', 500);
}