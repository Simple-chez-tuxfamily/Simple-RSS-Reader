/* Fonction qui cache l'erreur "Javascript n'est pas activé" */
function hide_msg(){
    document.getElementById('jserror').style.display = 'none';
}
/* Fonction pour redimensionner l'iframe principale (redimensionne toutes les 500ms */
function resize_frame(){
    var header_h = document.getElementById('header').offsetHeight;
    if(window.innerWidth < 500){
       alert('Votre écran est trop petit!');
    }
    document.getElementById('gauche').style.height = window.innerHeight - header_h + "px";
    document.getElementById('droite').style.height = window.innerHeight - header_h + "px";
    setTimeout("resize_frame()",500);
}
/* Fonction pour marquer un item comme lu/non lu */
function change_state(id,action){
    if(action == 'read'){
        i = i - 1;
        document.getElementById('i' + id).style.fontWeight = 'lighter';
        document.getElementById('fnl').innerHTML = 'Flux non lus (' + i + ')';
    }
    else{
        // Ici i ne fonctionne pas...
        parent.frames['top'].document.getElementById('i' + id).style.fontWeight = 'bold';
    }
}