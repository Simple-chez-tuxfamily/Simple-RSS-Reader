<?php
    /*
     * Interact.php est le *SEUL* fichier à appeler dans les fichiers js.
     * Usage : interact.php?action=fichier[&parametre1][&parametre2]
     * Attention: fichier ne doit PAS être accompagné de l'extension PHP
    */
    
    if(!empty($_GET['action']) && file_exists('interact/' . $_GET['action'] . '.php'))
        include 'interact/' . $_GET['action'] . '.php';
    else
        header('HTTP/1.0 404 Not Found');
?>