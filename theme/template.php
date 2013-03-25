<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Simple RSS Reader</title>
        <link rel="shortcut icon" type="image/png" href="theme/images/favicon.png" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        
        <link type="text/css" rel="stylesheet" href="core/css.php" />
        <script type="text/javascript" src="core/js.php"></script>
        
    </head>
    <body>
        <?php
            echo '<div id="notification" style="background:#D63535;">Erreur: Veuillez activer JavaScript!</div><header>
                <ul id="header_gauche"><li><a onclick="liste_ids();">Lancer une mise à jour des flux</a></li></ul>
                Simple RSS Reader <img id="chargement" src="theme/images/chargement.gif" />
                <ul id="header_droite">';
                if($_GET['p'] == 'parametres')
                    echo '<li><a href="?p=lire">Flux non lus (' . $nonlu . ')</a></li>';
                else
                    echo '<li><a href="?p=parametres">Paramètres</a></li>';
                echo'    <li><a href="?p=deconnexion">Déconnexion</a></li>
                </ul>
            </header><div id="cover_all"></div>'; 
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