/* Fonction pour redimensionner l'iframe principale (redimensionne toutes les 500ms*/
function resize_frame(){
    var header_h = 37; // Hauteur de <header>
    // Si la fenêtre est trop petite
    if(window.innerWidth < 500){
       alert('Votre écran est très petit!');
    }
    document.getElementById('content').style.height = window.innerHeight - header_h + "px";
    setTimeout("resize_frame()",500);
}
/* Fonction pour afficher une couleur différente sur l'onglet courant */
function change_color(id){
    document.getElementById('para').style.color = '#eee';
    document.getElementById('fnl').style.color = '#eee';
    document.getElementById(id).style.color = '#f1b880';
}
/* Fonction pour marquer un item comme lu/non lu */
function change_state(id,action){
    if(action == 'read'){
        document.getElementById('i' + id).style.fontWeight = 'lighter';
    }
    else{
        parent.frames['content'].document.getElementById('i' + id).style.fontWeight = 'bold';
    }
}