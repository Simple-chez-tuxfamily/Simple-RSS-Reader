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
        
        
        echo '<div id="entete">
                <div id="source">' . $feeds['title'] . '</div>                
                <div id="quitter" onclick="fermer_article()">X</div>
                <div id="markas" onclick="">Chargement en cours...</div>
                <div id="date">' . $date . '</div>
                <div class="clear"></div>
            </div>
            <h1 class="titre"><a href="' . $response['permalink'] . '" target="_blank">' . $response['title'] . '</a></h1>
            <div id="article_content">' . $response['description'] . '<br /></div>';
    }
?>