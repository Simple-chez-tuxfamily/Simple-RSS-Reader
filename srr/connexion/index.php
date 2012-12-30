<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Connexion - Simple RSS Reader</title>
	<link type="text/css" rel="stylesheet" href="../themes/defaut/template.css" />
        <link rel="shortcut icon" type="image/png" href="../favicon.png" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
    <?php
        if(isset($_COOKIE['is_connected'])){
            $cookie = explode(';',$_COOKIE['is_connected']);
            if(isset($cookie[0],$cookie[1]))
                header('Location: connect.php?cookie=1&pseudo=' . $cookie[0] . '&password=' . $cookie[1]);
        }
        elseif(!isset($_SESSION['uname']))
            echo '<header>Connexion</header>
            <form id="connexion" action="connect.php" method="get">
                <input type="text" name="pseudo" required placeholder="Nom d\'utilisateur..." />
                <input type="password" name="password" required placeholder="Mot de passe..." />
                <label><input type="checkbox" name="keep" /> Se souvenir de moi</label>
                <input type="submit" value="Connexion" />
            </form>';
        else
            header('Location: ../index.php');
    ?>
    </body>
</html>
