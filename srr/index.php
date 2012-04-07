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
            echo '<form id="connect" action="misc.php?connect" method="post"><h1>Connexion</h1>Nom d\'utilisateur:<br /><input type="text" name="pseudo" required /><br />Mot de passe:<br /><input type="password" name="password" required /><br /><br /><input type="checkbox" name="keep" /> Garder la connexion active<br /><br /><input type="submit" value="Connexion" /></form>';
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
                echo '<header><a href="params.php" target="apercu">Simple RSS Reader</a>';
                if(!$nothing){
                    if($result[0] == 1){
                        echo ' (1 non lu)';
                    }
                    else{
                        echo ' (' . $result[0] . ' non lus)';
                    }
                }
                echo '</header>';
            }
            if(!isset($_GET['read']) or !is_numeric($_GET['read'])){
                echo '<div id="gauche"><ul>';
                if(!$nothing){
                    $query = $sqlite->query('SELECT id,title FROM feeds');
                    while($response = $query->fetch()){
                        $name[$response['id']] = $response['title'];
                    }
                    $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' ORDER BY date DESC');
                    while($response = $query->fetch()){
                        echo '<li><h2><a target="apercu" id="i' . $response['id'] . '" onclick="document.getElementById(\'i' . $response['id'] . '\').style.fontWeight = \'lighter\'" href="?read=' . $response['id'] . '&frame">' . $response['title'] . '</a></h2>' . $name[$response['feed_id']] . '</li>';
                    }
                }
                echo '<li style="border-top:1px solid #bbb;margin-top:-1px;"><h2><a href="check.php">Lancer une recherche</a></h2>Cliquez ici pour lancer une recherche</li></ul></div><div id="droite"><iframe width="100%" height="100%" scrolling="auto" frameborder="0" src="?read=9999999999&frame" name="apercu"></iframe></div>';
            }
            else{
                $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['read']));
                $response = $query->fetch();
                if(!empty($response['title'])){
                    echo '<article><h1><a href="' . $response['permalink'] . '">' . $response['title'] . '</a></h1><span id="infos">Posté le ' . date('d/m/Y à G\hi\m',$response['date']) . '. <a onclick="parent.frames[\'top\'].document.getElementById(\'i' . $response['id'] . '\').style.fontWeight = \'bold\'" style="color:#888;text-decoration:none;font-weight:bold;" href="misc.php?unread=' . $_GET['read'] . '">Marquer comme non lu</a></span><hr />' . $response['description'] . '</article><hr style="visibility:hidden;"/><br style="visibility:hidden;" /><hr style="visibility:hidden;" />';
                    if(!isset($_GET['unread'])){
                        $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['read']));
                    }
                }
            }
        }
    ?>
    </body>
</html>