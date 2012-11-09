<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?> - Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/defaut/theme.css" />
        <link rel="shortcut icon" type="image/png" href="themes/defaut/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    </head>
    <body>
            <div id="das_big_message">
                <div id="message_content">
                    <strong>Erreur</strong>
                    <p>Javascript semble être désactivé. Pour pouvoir utiliser Simple RSS Reader, vous devez impérativement activer Javascript dans les préférences de votre navigateur.</p>
                </div>
            </div>
            <header>
                Simple RSS Reader
                <div id="menu_gauche">
                    <?php
                        if($page == 'flux') echo '<a href="check.php?id=' . $_SESSION['id'] . '" onclick="check(' . $_SESSION['theme'] . ';">Lancer une recherche</a><a onclick="mask_all()">Tout masquer</a>';
                        else{
                            echo '<a class="button" href="?p=parametres&page=flux">Flux suivis</a><a class="button" href="?p=parametres&page=compte">Mon compte</a>';
                            if($_SESSION['admin'] == 1) echo '<a class="button" href="?p=parametres&page=utilisateurs">Gestion des utilisateurs</a>';
                        }
                    ?>
                </div>
                <div id="menu_droite">
                    <?php
                        if($page == 'flux') echo '<a href="?p=parametres">Paramètres</a>';
                        else echo '<a href="?p=index">Flux non lus</a>';
                    ?>
                    <a href="connexion/disconnect.php">Déconnexion</a>
                </div>
            </header>
            <div id="content"><?php echo $content; ?></div>
            <script type="text/javascript" src="themes/defaut/theme.js"></script>
            <script>hide_msg();is_mobile();</script>
    </body>
</html>