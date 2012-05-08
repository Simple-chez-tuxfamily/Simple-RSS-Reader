<?php
    session_start();
    if(!isset($_SESSION['uname'])){
        header('Location: connexion/');
    }
    elseif(isset($_GET['mobile'])){
        $_SESSION['theme'] = 'mobile';
    }
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
    <body onload="hide_msg();resize_frame();change_color('fnl');">
        <h1 id="jserror" style="color:#aa0000;margin:5px;">Erreur: Javascript n'est pas activé!</h1>
    <?php
        $sqlite = new PDO('sqlite:include/data.db');
        $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
        $result = $result->fetch();
        echo '<header id="header"><h1>Simple RSS Reader</h1><ul id="menu">
            <li><a href="connexion/disconnect.php">Déconnexion</a></li>
            <li><a id="para" onclick="change_color(\'para\')"href="parametres/" target="content">Paramètres</a></li>
            <li><a id="fnl" onclick="change_color(\'fnl\')" href="read.php" target="content">Flux non lus (' . $result[0] . ')</a></li>
        </ul></header><iframe width="100%" scrolling="auto" frameborder="0" src="read.php" id="content" name="content"></iframe>';
    ?>
    </body>
</html>