<?php
    if(!isset($_GET['id']) or !is_numeric($_GET['id']))
        exit('Erreur: aucun ID n\'a été défini');
    
    $sqlite = new PDO('sqlite:private/data.db');

    $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['id']) . ' AND user_id="' . $_SESSION['id'] . '"');
    $response = $query->fetch();
    if(!empty($response['title'])){
        // Si le titre n'est pas vide, on récupère le nom du flux auquel appartient l'item
        $query = $sqlite->query('SELECT title FROM feeds WHERE user_id="' . $_SESSION['id'] . '" AND id=' . $sqlite->quote($response['feed_id']));
        $feeds = $query->fetch();
        
        // On récupère l'ID de l'item précédant l'item en cours
        $query = $sqlite->query('SELECT id FROM items WHERE date < ' . $response['date'] . ' AND user_id="' . $_SESSION['id'] . '" AND read = 0 ORDER BY date DESC');
        $precedent = $query->fetch();
        
        // On récupère l'ID de l'item suivant l'item en cours
        $query = $sqlite->query('SELECT id FROM items WHERE date > ' . $response['date'] . ' AND user_id="' . $_SESSION['id'] . '" AND read = 0 ORDER BY date ASC');
        $suivant = $query->fetch();
        
        
        // Formatage de la date
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
            </div>';
            
        if(is_numeric($precedent['id'])) // Si il existe un ID précédent
            echo '<div class="flottant" id="btn_precedent" onclick="load_item(\'' . $precedent['id'] . '\');"><</div>';
        
        if(is_numeric($suivant['id'])) // Si il existe un ID suivant
            echo '<div class="flottant" id="btn_suivant" onclick="load_item(\'' . $suivant['id'] . '\');">></div>';
            
        echo' <h1 class="titre"><a href="' . $response['permalink'] . '" target="_blank">' . $response['title'] . '</a></h1>
            <div id="article_content">' . $response['description'] . '<br /></div>';
    }
?>