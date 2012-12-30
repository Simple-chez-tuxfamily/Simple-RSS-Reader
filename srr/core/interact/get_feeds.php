<?php
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');

    $query = $sqlite->query('SELECT * FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
    $liste = null;
    
    while($response = $query->fetch())
        $liste .= $response['id'] . ';';
    echo substr($liste, 0, -1);
?>