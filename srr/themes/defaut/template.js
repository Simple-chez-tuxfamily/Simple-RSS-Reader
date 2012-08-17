/* Fonction qui cache l'erreur "Javascript n'est pas activé" */
function hide_msg(){
    document.getElementById('das_big_message').style.display = 'none';
}
/* Fonction qui affiche un message à l'écran */
function show_message(title, message, image){
    if(!image){ /* Si il n'y a pas d'image */
        document.getElementById('das_big_message').innerHTML = '<div id="message_content"><strong>' + title + '</strong><p>' + message + '</p></div>';
    }
    else{
        document.getElementById('das_big_message').innerHTML = '<div id="message_content"><strong>' + title + '</strong><p>' + message + '</p><img src="' + image + '" /></div>';
    }
    document.getElementById('das_big_message').style.display = 'block';
}
/* Fonction pour redimensionner l'iframe principale (redimensionne toutes les 500ms */
function resize_frame(){
    var header_h = document.getElementById('header').offsetHeight;
    if(window.innerWidth < 500){
       window.location.href = 'index.php?p=index&mobile';
    }
    document.getElementById('gauche').style.height = window.innerHeight - header_h + "px";
    document.getElementById('droite').style.height = window.innerHeight - header_h + "px";
    setTimeout("resize_frame()",500);
}
/* Fonction pour marquer un item comme lu/non lu */
function change_state(id,action){
    if(action == 'read'){
        i = i - 1;
        if(i < 0){ i = 0; }
        document.getElementById('i' + id).style.fontWeight = 'lighter';
        document.getElementById('fnl').innerHTML = 'Flux non lus (' + i + ')';
    }
    else{
        window.frames.top.i = window.frames.top.i + 1;
        parent.frames['top'].document.getElementById('fnl').innerHTML = 'Flux non lus (' + window.frames.top.i + ')';
        parent.frames['top'].document.getElementById('i' + id).style.fontWeight = 'bold';
    }
}