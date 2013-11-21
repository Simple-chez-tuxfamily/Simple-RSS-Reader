/*
 * Design.js
 * Les fonctions présentes dans ce fichier permettent d'interagir avec le design
*/

/*
  * Fonction qui permet de changer le titre de la page
*/
function changer_titre(){
    document.title = '(' + items_non_lus + ') Flux non lus - Simple RSS Reader';
}

/*
 * Fonction qui permet de masquer la balise article si SRR se charge avec son thème mobile
*/

function article_mobile(){
    if(document.getElementsByTagName('article')[0] && window.innerWidth <= 700)
        document.getElementsByTagName('article')[0].style.display = 'none';
}

/*
  * Fonction qui permet de redimensionner les divs (liste des items, menu des paramètres et article) automatiquement toutes les 500ms
*/
function resize_divs(){    
    if(document.getElementsByTagName('article')[0])
        document.getElementsByTagName('article')[0].style.height = window.innerHeight + "px";
       
    if(document.getElementsByTagName('nav')[0] && window.innerWidth <= 700)
        document.getElementsByTagName('nav')[0].style.height = window.innerHeight - 50 + "px";
        
    else if(document.getElementsByTagName('nav')[0] && window.innerWidth > 700)
        document.getElementsByTagName('nav')[0].style.height = window.innerHeight - 35 + "px";
    
    setTimeout('resize_divs()', 500);
}

/*
  * Fermer l'article (mobile)
*/
function fermer_article(){
    if(document.getElementsByTagName('article')[0])
        document.getElementsByTagName('article')[0].style.display = 'none';
}

/*
 * Afficher l'article (mobile)
*/
function afficher_article(){    
    if(document.getElementsByTagName('article')[0] && window.innerWidth <= 700)
        document.getElementsByTagName('article')[0].style.display = 'block';
}