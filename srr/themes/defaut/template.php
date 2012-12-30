<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Simple RSS Reader</title>
        <link rel="shortcut icon" type="image/png" href="themes/defaut/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        
        <link type="text/css" rel="stylesheet" href="core/css.php" />
        <script type="text/javascript" src="core/js.php"></script>
        
    </head>
    <body>
        <?php
            if(!isset($_GET['nobar']))
                echo '<div id="notification" style="background:#D63535;">Erreur: Veuillez activer JavaScript!</div><header>
                    <ul id="header_gauche"><li><a onclick="liste_ids();">Lancer une mise à jour des flux</a></li></ul>
                    Simple RSS Reader <img id="chargement" src="themes/defaut/images/chargement.gif" />
                    <ul id="header_droite">';
                    if($_GET['p'] == 'parametres')
                        echo '<li><a href="?p=index">Flux non lus (' . $nonlu . ')</a></li>';
                    else
                        echo '<li><a href="?p=parametres">Paramètres</a></li>';
                    echo'    <li><a href="connexion/disconnect.php">Déconnexion</a></li>
                    </ul>
                </header>'; 
            echo $content;
            if(!isset($_GET['nobar'])){
                echo '<script type="text/javascript">
                    masquer_message();
                    resize_divs();
                    staying_alive();
                    var items_non_lus = ' . $nonlu . ';
                </script>';
            }
        ?>
    </body>
</html>