/*
 * Items.js
 * Les fonctions présentes dans ce fichier permettent d'interagir avec les items
*/

/*
  * Fonction qui charge un item
*/
function load_item(id){
    var xhr = getXMLHttpRequest();
    
    // Pour le thème mobile: permet de contrôler l'affichage de l'article   
    afficher_article();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {         
            document.getElementsByTagName('article')[0].scrollTop = 0; // Permet de retourner automatiquement en haut de l'article   
            document.getElementsByTagName('article')[0].innerHTML = xhr.responseText;
            mark_as(id, 1);
        }
    };
    xhr.open('GET', 'core/interact.php?action=get&token=[PHP_ADD_TOKEN]&id=' + id, true);
    xhr.send(null);
    return false;
}

/*
  * Fonction qui change l'état d'un item (lu ou non)
*/
function mark_as(id, lu){        
    var xhr = getXMLHttpRequest();
    
    if(lu == 0){
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
                document.getElementById('markas').onclick = function() {mark_as(id, 1);}
                document.getElementById('markas').innerHTML = 'Marquer comme lu';
                if(document.getElementById('item' + id).className == 'lu')
                    items_non_lus++;
                document.getElementById('item' + id).className = 'nonlu';
                changer_titre();
            }
        };
        xhr.open('GET', 'core/interact.php?action=set&token=[PHP_ADD_TOKEN]&id=' + id + '&as=unread', true);
        xhr.send(null);
    }
    else{
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)){
                document.getElementById('markas').onclick = function() {mark_as(id, 0);}
                document.getElementById('markas').innerHTML = 'Marquer comme non lu';
                if(document.getElementById('item' + id).className == 'nonlu')
                    items_non_lus--;
                document.getElementById('item' + id).className = 'lu';
                changer_titre();
            }
        };
        xhr.open('GET', 'core/interact.php?action=set&token=[PHP_ADD_TOKEN]&id=' + id + '&as=read', true);
        xhr.send(null);
    }
}

/*
 * Fonction qui masque les items lus
*/
function effacer_lus(){
    if(!document.getElementsByClassName) // Si la fonction (récente) n'existe pas, on abandonne
        return false;
    
    // On demande confirmation
    if(confirm('Effacer les items lus?')){    
        var items_lus = document.getElementsByClassName('lu');
        
        for(var i in items_lus)
            items_lus[i].style.display = 'none';
    }
    
    return true;    
}