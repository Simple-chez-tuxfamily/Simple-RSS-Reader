<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/defaut/<?php echo $page; ?>.css" />
        <link rel="shortcut icon" type="image/png" href="themes/defaut/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        <script type="text/javascript" src="themes/defaut/template.js"></script>
    </head>
    <body>
        <?php
            if(!isset($_GET['nobar'])){ echo '<div id="das_big_message"><div id="message_content"><strong>Erreur</strong><p>Javascript semble être désactivé. Pour pouvoir utiliser Simple RSS Reader, vous devez impérativement activer Javascript dans les préférences de votre navigateur.</p></div></div><header id="header"><h1>Simple RSS Reader</h1><ul id="menu"><li><a href="connexion/disconnect.php">Déconnexion</a></li><li><a href="?p=parametres">Paramètres</a></li><li><a id="fnl" href="?p=index">Flux non lus (' . $nonlu . ')</a></li></ul></header>'; }
            echo $content;
            if(!isset($_GET['nobar'])){
                echo '<script type="text/javascript">
                    hide_msg();
                    resize_frame();
                    var i=' . $nonlu . ';
                </script>';
            }
        ?>
    </body>
</html>