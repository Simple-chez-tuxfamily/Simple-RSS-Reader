<?php
    if(!isset($_GET['id']) or !is_numeric($_GET['id']))
        exit('Erreur: aucun ID n\'a été défini');
    
    $sqlite = new PDO('sqlite:private/data.db');

    $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['id']) . ' AND user_id="' . $_SESSION['id'] . '"');
    $response = $query->fetch();
    if(!empty($response['title'])){    
        $query = $sqlite->query('SELECT title FROM feeds WHERE user_id="' . $_SESSION['id'] . '" AND id=' . $sqlite->quote($response['feed_id']));
        $feeds = $query->fetch();
        
        if(date('dmY', $response['date']) == date('dmY'))
            $date = date('H:i', $response['date']);
        else
            $date = date('d/m/Y', $response['date']);
        
        echo '<div id="infos">
        <div id="left"><a href="' . $response['permalink'] . '" target="_blank">' . $response['title'] . '</a></div>
        <div id="right">
            <div class="case">' . $feeds['title'] . '</div>
            <div class="case">' . $date . '</div>
            <div class="case" id="markas" onclick=""></div>
        </div>
        </div><div id="article_content">' . $response['description'] . '<br /></div>';
    }
?>