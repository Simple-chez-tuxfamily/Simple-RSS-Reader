/* Fonction qui cache l'erreur "Javascript n'est pas activé" */
function hide_msg(){
    document.getElementById('das_big_message').style.display = 'none';
}
/* Fonction qui déclenche l'affichage de la version mobile */
function is_mobile(){
    if(window.innerWidth < 500){
       window.location.href = 'index.php?p=index&mobile';
    }
    setTimeout('is_mobile',500);
}
/* Fonction qui affiche un message à l'écran */
function show_message(title, message, image){
    if(!image){ /* Si il n'y a pas d'image */
        document.getElementById('das_big_message').innerHTML = '<div id="message_content"><strong>' + title + '</strong><p>' + message + '</p></div>';
    }
    else{
        document.getElementById('das_big_message').innerHTML = '<div id="message_content"><strong>' + title + '</strong><p>' + message + '</p><center><img src="' + image + '" /></center></div>';
    }
    document.getElementById('das_big_message').style.display = 'block';
    get_done();
}
function get_done(){
    setTimeout('get_done()', 500);
}
/* Fonction pour afficher/masquer un item et le marquer comme lu */
function read(id){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'setas.php?read=' + id, true);
    xhr.send(null);
    if(document.getElementById('c' + id).style.display == 'table-row'){
        document.getElementById('c' + id).style.display = 'none';
    }
    else{
        document.getElementById('i' + id).style.fontWeight = 'lighter';
        document.getElementById('c' + id).style.display = 'table-row';
        load_elements('c' + id);
    }
}
/* Fonction pour marquer un item comme non lu */
function unread(id){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'setas.php?unread=' + id, true);
    xhr.send(null);
    document.getElementById('i' + id).style.fontWeight = 'bold';
}
/* Fonction qui masque tous les .article */
function mask_all(){
    articles = document.getElementsByClassName('article');
    for(var i=0;i<articles.length;i++) articles[i].style.display = 'none';
}
function check(theme){
    show_message('Recherche en cours...', 'La recherche de nouveaux items est en cours, veuillez patienter...','themes/' + theme + '/images/loading.gif')
}
/* Fonction qui charge les éléments externes au clic */
function load_elements(from){
    
}