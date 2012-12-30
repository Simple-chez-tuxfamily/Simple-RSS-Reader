<?php
    if(!isset($_GET['id']) or !is_numeric($_GET['id']))
        exit('Erreur: aucun ID n\'a été défini');
    if(!(isset($_GET['as']) && ($_GET['as'] == 'read' or $_GET['as'] == 'unread')))
        exit('Erreur: mauvais argument');
    
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');

    if($_GET['as'] == 'read')
        $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['id']) . ' AND user_id="' . $_SESSION['id'] . '"');
    else
        $sqlite->query('UPDATE items SET read=\'0\' WHERE id=' . $sqlite->quote($_GET['id']) . ' AND user_id="' . $_SESSION['id'] . '"');
?>