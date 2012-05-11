<?php
    $title = 'Flux non lus';
    if(isset($_SESSION['uname'])){
        if(isset($_GET['read']) && is_numeric($_GET['read'])){
            $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
            $response = $query->fetch();
            if(!empty($response['title'])){
                $title = $response['title'];
                $response['description'] = preg_replace('/<script\b/i', '<div class="xss">', $response['description']);
                $response['description'] = preg_replace('/<\/script>\b/i', '</div>', $response['description']);
                $response['description'] = preg_replace('/on([a-z]+)/i', '', $response['description']);
                echo '<article><h1><a href="' . $response['permalink'] . '">' . $response['title'] . '</a></h1><span id="infos">Posté le ' . date('d/m/Y à G\hi\m',$response['date']) . '. <a onclick="change_state(\'' . $response['id'] . '\',\'unread\')" style="color:#888;text-decoration:none;font-weight:bold;" href="?p=index&read=' . $_GET['read'] . '&unread&nobar">Marquer comme non lu</a></span><hr />' . $response['description'] . '</article>';
                if(!isset($_GET['unread'])){
                    $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
                }
                else{
                    $sqlite->query('UPDATE items SET read=\'0\' WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
                }
            }
        }
        else{
            $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
            $result = $result->fetch();
            echo '<div id="gauche"><ul>';
            if($result[0] > 0){
                $query = $sqlite->query('SELECT id,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                while($response = $query->fetch()){
                    $name[$response['id']] = $response['title'];
                }
                $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' AND user_id="' . $_SESSION['id'] . '" ORDER BY date DESC');
                while($response = $query->fetch()){
                    echo '<li><h2><a target="apercu" id="i' . $response['id'] . '" onclick="change_state(\'' . $response['id'] . '\',\'read\')" href="?p=index&read=' . $response['id'] . '&nobar">' . $response['title'] . '</a></h2>' . $name[$response['feed_id']] . '</li>';
                }
            }
            echo '<li style="border-top:1px solid #bbb;margin-top:-1px;"><h2><a href="check.php?id=' . $_SESSION['id'] . '" target="_top">Lancer une recherche</a></h2>Cliquez ici pour lancer une recherche</li></ul></div><div id="droite"><iframe width="100%" height="100%" scrolling="auto" frameborder="0" src="read.php?read=-1&nobar" id="apercu" name="apercu"></iframe></div>';
        }
    }
?>