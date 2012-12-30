<?php
    if(!isset($_GET['id']) or !is_numeric($_GET['id']))
        exit('Erreur: aucun ID n\'a été défini');
    
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');

    $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['id']) . ' AND user_id="' . $_SESSION['id'] . '"');
    $response = $query->fetch();
    if(!empty($response['title']))
        echo '<div class="article_content"><h1><a href="' . $response['permalink'] . '" target="_blank">' . $response['title'] . '</a></h1><span id="infos">Posté le ' . date('d/m/Y à G\hi\m', $response['date']) . '. <a id="markas" onclick=""></a></span><hr />' . $response['description'] . '</div>';
?>