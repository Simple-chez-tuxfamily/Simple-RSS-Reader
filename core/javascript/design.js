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
    var infos_h = 30; // La hauteur totale de la div infos
    var padding = 20;// Le padding top et bottom de la div article_content
    
    if(document.getElementById('items'))
        document.getElementById('items').style.height = window.innerHeight - header_h + "px";
    
    if(document.getElementById('parametres'))
        document.getElementById('parametres').style.height = window.innerHeight - header_h + "px";
        
    if(document.getElementById('article_content'))
        document.getElementById('article_content').style.height = window.innerHeight - (header_h + infos_h + padding + 3) + "px";
    
    setTimeout('resize_divs()', 500);
}