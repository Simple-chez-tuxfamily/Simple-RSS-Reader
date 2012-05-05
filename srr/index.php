<?php
    session_start();
    if(!isset($_SESSION['theme'])){
        $_SESSION['theme'] = 'defaut';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $_SESSION['theme']; ?>/style.css" />
        <link rel="shortcut icon" type="image/png" href="themes/<?php echo $_SESSION['theme']; ?>/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
    <?php
        if(!isset($_SESSION['uname'])){
            header('Location: connexion/');
        }
        else{
            $sqlite = new PDO('sqlite:include/data.db');
            $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
            $result = $result->fetch();
            echo '<header><a href="parametres/" target="apercu">Simple RSS Reader</a>';
            if($result[0] == 1){
                    echo ' (1 non lu)';
            }
            elseif($result[0] > 1){
                echo ' (' . $result[0] . ' non lus)';
            }
            echo '</header><div id="gauche"><ul>';
            if($result[0] > 0){
                $query = $sqlite->query('SELECT id,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                while($response = $query->fetch()){
                    $name[$response['id']] = $response['title'];
                }
                $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' AND user_id="' . $_SESSION['id'] . '" ORDER BY date DESC');
                while($response = $query->fetch()){
                    echo '<li><h2><a target="apercu" id="i' . $response['id'] . '" onclick="document.getElementById(\'i' . $response['id'] . '\').style.fontWeight = \'lighter\'" href="read.php?read=' . $response['id'] . '">' . $response['title'] . '</a></h2>' . $name[$response['feed_id']] . '</li>';
                }
            }
            echo '<li style="border-top:1px solid #bbb;margin-top:-1px;"><h2><a href="check.php?id=' . $_SESSION['id'] . '">Lancer une recherche</a></h2>Cliquez ici pour lancer une recherche</li></ul></div><div id="droite"><iframe width="100%" height="100%" scrolling="auto" frameborder="0" src="read.php" name="apercu"></iframe></div>';
        }
    ?>
    </body>
</html>