/* Fonction qui cache l'erreur "Javascript n'est pas activé" */
function hide_msg(){
    document.getElementById('jserror').style.display = 'none';
}
/* Fonction pour redimensionner l'iframe principale (redimensionne toutes les 500ms */
function resize_frame(){
    var header_h = document.getElementById('header').offsetHeight + 3;
    if(window.innerWidth > 500){
       window.location.href = 'index.php?p=index&desktop';
    }
    document.getElementById('droite').style.height = window.innerHeight - header_h + "px";
    setTimeout("resize_frame()",500);
}
/* Fonction pour marquer un item comme lu/non lu */
function change_state(id,action){
    if(action == 'read'){
        document.getElementById('gauche').style.display = 'none';
        document.getElementById('droite').style.display = 'block';
    }
}