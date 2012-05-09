<?php
    if(file_exists('../installation/install.php')){
        header('Location: ../installation/index.php');
    }
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Connexion - Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="../themes/defaut/params.css" />
        <link rel="shortcut icon" type="image/png" href="../favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
    <?php
        if(isset($_COOKIE['is_connected'])){
            $cookie = explode(';',$_COOKIE['is_connected']);
            if(isset($cookie[0],$cookie[1])){
                header('Location: connect.php?cookie=1&pseudo=' . $cookie[0] . '&password=' . $cookie[1]);
            }
        }
        elseif(!isset($_SESSION['uname'])){
            echo '<form id="connect" action="connect.php" method="get">
                <h1>Connexion</h1>
                <label for="pseudo">Nom d\'utilisateur:</label><br /><input type="text" name="pseudo" required /><br />
                <label for="password">Mot de passe:</label><br /><input type="password" name="password" required /><br /><br />
                <input type="checkbox" name="keep" /> <label for="keep">Garder la connexion active</label><br /><br />
                <input type="submit" value="Connexion" />
            </form>';
        }
        else{
            header('Location: ../index.php');
        }
    ?>
    </body>
</html>