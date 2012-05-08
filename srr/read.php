<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $_SESSION['theme']; ?>/style.css" />
        <link rel="shortcut icon" type="image/png" href="themes/<?php echo $_SESSION['theme']; ?>/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <script type="text/javascript" src="srr.js"></script>
    </head>
    <body>
    <?php
        if(isset($_SESSION['uname'])){
            $sqlite = new PDO('sqlite:include/data.db');
            if(isset($_GET['read']) && is_numeric($_GET['read'])){
                $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
                $response = $query->fetch();
                if(!empty($response['title'])){
                    echo '<article><h1><a href="' . $response['permalink'] . '">' . $response['title'] . '</a></h1><span id="infos">Posté le ' . date('d/m/Y à G\hi\m',$response['date']) . '. <a onclick="change_state(\'' . $response['id'] . '\',\'unread\')" style="color:#888;text-decoration:none;font-weight:bold;" href="read.php?read=' . $_GET['read'] . '&unread">Marquer comme non lu</a></span><hr />' . $response['description'] . '</article>';
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
                        echo '<li><h2><a target="apercu" id="i' . $response['id'] . '" onclick="change_state(\'' . $response['id'] . '\',\'read\')" href="read.php?read=' . $response['id'] . '">' . $response['title'] . '</a></h2>' . $name[$response['feed_id']] . '</li>';
                    }
                }
                echo '<li style="border-top:1px solid #bbb;margin-top:-1px;"><h2><a href="check.php?id=' . $_SESSION['id'] . '" target="_top">Lancer une recherche</a></h2>Cliquez ici pour lancer une recherche</li></ul></div><div id="droite"><iframe width="100%" height="100%" scrolling="auto" frameborder="0" src="read.php?read=-1" id="apercu" name="apercu"></iframe></div>';
            }
        }
    ?>
    </body>
</html>