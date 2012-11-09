<?php
    
    // Fonction qui bloque le chargement des éléments externes et qui force l'ouverture des liens dans une nouvelle fenêtre
    function block_element($from){
        $from = preg_replace('/ ?src="?\'?([^"\']+)"?\'?/im', ' class="antichargement" data-original="$1" src="themes/' . $_SESSION['theme']  . '/images/transparent.png"', $from);
        $from = str_replace('<a','<a target="_blank"', $from);
        return $from;
    }
    
    if(isset($_SESSION['uname'])){
        $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
        $result = $result->fetch();
        if($_SESSION['admin'] == 1){
            $version = 2.0; // Numéro de version
            $actuel = floatval(file_get_contents('http://quent1-fr.github.com/Simple-RSS-Reader/version.srr'));  // Version stable courante
            if($actuel > $version) echo '<div class="message confirmation">Une mise à jour est disponible. <a href="https://github.com/quent1-fr/Simple-RSS-Reader/zipball/master">Cliquez ici</a> pour la télécharger</div>';
        }
        $nombre_unread = 0;
        echo '<table><tr><th>Titre</th><th>De</th><th>Date</th></tr>';
        if($result[0] > 0){
            $query = $sqlite->query('SELECT id,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
            while($response = $query->fetch()) $name[$response['id']] = $response['title'];
            $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' AND user_id="' . $_SESSION['id'] . '" ORDER BY date DESC');
            while($response = $query->fetch()){
                if(empty($response['description'])) $response['description'] = 'Aucun contenu...';
                echo '<tr><td><a class="title" id="i' . $response['id'] . '" onclick="read(' . $response['id'] . ')">' . $response['title'] . '</a></a></td><td>' . $name[$response['feed_id']] . '</td><td>Le ' . date('d/m à H:i',$response['date']) . '</td></tr>
                <tr class="article" id="c' . $response['id'] . '"><td colspan="3">' . block_element($response['description']) . '<div class="droite" style="margin-top:30px;"><a onclick="unread(' . $response['id'] . ')">Marquer comme non lu &raquo;</a>&nbsp;&nbsp;&nbsp;<a href="' .  $response['permalink'] . '" target="_blank">Lire l\'article original &raquo;</a></div></td></tr>';
                $nombre_unread++;
            }
        }
        else{
            echo '<tr><td colspan="3">Il n\'y a rien à lire ici...</td></tr>';
        }
        echo '</table>';
        if($nombre_unread > 0) $title = '(' . $nombre_unread . ') Flux non lus';
        else $title = 'Flux non lus';
    }
?>