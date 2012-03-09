<?php
    session_start();
    include 'config.php';
    if(!isset($_SESSION['uname']) && isset($_COOKIE['is_connected']) && $_COOKIE['is_connected'] == $config['uname'] . ';' . $config['passwd']){
        $_SESSION['uname'] = $config['uname'];
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $config['theme']; ?>/style.css" />
        <link rel="shortcut icon" type="image/png" href="favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
    <?php
        if(!isset($_SESSION['uname'])){
            echo '<h1 id="titre">Connexion</h1><form action="misc.php?connect" method="post">Nom d\'utilisateur:<br /><input type="text" name="pseudo" required /><br />Mot de passe:<br /><input type="password" name="password" required /><br /><br /><input type="checkbox" name="keep" /> Garder la connexion active<br /><br /><input type="submit" value="Connexion" /></form>';
        }
        else{
            $sqlite = new PDO('sqlite:data.db');
            $result = $sqlite->query('SELECT count(id) FROM items WHERE read=\'0\'');
            $result = $result->fetch();
            if($result[0] > 0){
                $nothing = false;
            }
            else{
                $nothing = true;
            }
            if(!isset($_GET['frame'])){
                echo '<header>Simple RSS Reader';
                if(!$nothing){
                    echo ' (' . $result[0] . ' non lus)';
                }
                echo '</header>';
            }
            if(!isset($_GET['read']) or !is_numeric($_GET['read'])){
                if(!$nothing){
                    echo '<div id="gauche"><ul>';
                    $query = $sqlite->query('SELECT id,title FROM feeds');
                    while($response = $query->fetch()){ $name[$response['id']] = $response['title']; }
                    $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' ORDER BY date DESC');
                    while($response = $query->fetch()){ echo '<li><h2><a target="apercu" href="?read=' . $response['id'] . '&frame">' . utf8_encode($response['title']) . '</a></h2>' . utf8_encode($name[$response['feed_id']]) . '</li>'; }
                    echo '</ul></div><div id="droite"><iframe width="100%" height="100%" scrolling="auto" frameborder="0" src="?read=9999999999&frame" name="apercu"></iframe></div>';
                }
                else{
                    echo '<p style="text-align:center;font-size:17px;padding-top:40px;">Il n\'y a rien à afficher...</p>';
                }
            }
            else{
                $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['read']));
                $response = $query->fetch();
                if(!empty($response['title'])){
                    echo '<article><h1><a href="' . $response['permalink'] . '">' . $response['title'] . '</a></h1><span id="infos">Posté le ' . date('d/m/Y à G\hi\m',$response['date']) . '</span><hr />' . $response['description'] . '</article>';
                    $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['read']));
                }
            }
        }
    ?>
    </body>
</html>