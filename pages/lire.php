<?php
    if(isset($_SESSION['uname'])){
        $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
        $result = $result->fetch();
        echo '<nav id="items"><ul>';
        if($result[0] > 0){
            $query = $sqlite->query('SELECT id,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
            while($response = $query->fetch())
                $name[$response['id']] = $response['title'];
            $i = 0;
            $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' AND user_id="' . $_SESSION['id'] . '" ORDER BY date DESC');
            while($response = $query->fetch()){
                $i++;
                echo '<li id="item' . $response['id'] . '" onclick="load_item(\'' . $response['id'] . '\');" class="nonlu"><h2>' . $response['title'] . '</h2>' . $name[$response['feed_id']] . '</li>';
            }
        }
        else{
            echo '<li id="no_click"><h2><a>Vous n\'avez rien à lire</a></h2>Lancez donc une mise à jour des flux!</li>';
            $i = 0;
        }
        echo '</nav><article></article>';        
        $title = '(' . $i . ') Flux non lus';
    }
?>