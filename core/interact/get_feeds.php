<?php
    $sqlite = new PDO('sqlite:private/data.db');

    $query = $sqlite->query('SELECT * FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
    $liste = null;
    
    while($response = $query->fetch())
        $liste .= $response['id'] . ';';
    echo substr($liste, 0, -1);
?>