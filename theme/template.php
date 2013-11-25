<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Simple RSS Reader</title>
        <link rel="shortcut icon" type="image/png" href="theme/images/favicon.png" />
        <link rel="apple-touch-icon" href="theme/images/favicon.png" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        <style type="text/css">
            @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,700);
        </style>
        <link type="text/css" rel="stylesheet" href="core/css.php" />
        <script type="text/javascript" src="core/js.php"></script>
    </head>
    <body>
        <?php
            echo '<div id="notification" style="background:#D63535;">Erreur: Veuillez activer JavaScript!</div>            
            <div id="menu">
                <a onclick="liste_ids();" title="Actualiser les flux"><img src="theme/images/actualiser.png" alt="Actualiser les flux" /></a>';
                if($_GET['p'] == 'parametres')
                    echo '<a href="?p=lire" title="Flux non lus (' . $nonlu . ')"><img src="theme/images/flux.png" alt="Flux non lus (' . $nonlu . ')" /></a>';
                else
                    echo '<a onclick="effacer_lus();" title="Effacer les items lus"><img src="theme/images/effacer.png" alt="Effacer les items lus" /></a>
                    <a href="?p=parametres" title="Paramètres"><img src="theme/images/parametres.png" alt="Paramètres" /></a>';
                echo'    <a href="?p=deconnexion" title="Déconnexion"><img src="theme/images/deconnexion.png" alt="Déconnexion" /></a>
                </ul>
            </div>
            
            <div id="cover_all"></div>'; 
            echo $content;
            if(!isset($_GET['nobar'])){
                echo '<script type="text/javascript">
                    masquer_message();
                    article_mobile();
                    staying_alive();
                    resize_divs();
                    var items_non_lus = ' . $nonlu . ';
                </script>';
            }
        ?>
    </body>
</html>