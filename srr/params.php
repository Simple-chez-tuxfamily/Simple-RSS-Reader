<?php
    session_start();
    include 'config.php';        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paramètres</title>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $config['theme']; ?>/params.css" />
        <link rel="shortcut icon" type="image/png" href="favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php
            if(isset($_SESSION['uname'])){
                echo '<article><h1>Paramètres (<a href="misc.php?disconnect">déconnexion</a>)</h1><hr />
                <fieldset><legend>Gestion des flux</legend><h2>Ajouter un flux</h2>
                <form action="misc.php" method="get">
                    <label for="url">Adresse du flux:</label><input type="url" name="url" required /><br /><br />
                    <label for="nothing"></label><input type="submit" value="Ajouter le flux" /></form>';
                $sqlite = new PDO('sqlite:data.db');
                $query = $sqlite->query('SELECT id,url,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                $nbr = $sqlite->query('SELECT count(id) FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                $nbr = $nbr->fetch();
                if($nbr[0] > 0){
                    echo '<br /><br /><h2>Gérer les ' . $nbr[0] . ' flux</h2><table><thead><tr><td>Nom du flux</td><td>Action</td></tr></thead><tbody>';
                    while($response = $query->fetch()){
                        echo '<tr><td><a href="' . $response['url'] . '">' . $response['title'] . '</a></td><td><a href="misc.php?del=' . $response['id'] . '">Supprimer</a></td></tr>';
                    }
                    echo '</tbody></table>';
                }
                echo '</fieldset>';
                if($_SESSION['admin'] == 1){
                    echo '<br /><br /><fieldset><legend>Gestion des utilisateurs</legend><h2>Ajouter un utilisateur</h2>
                    <form action="misc.php?adduser" method="POST">
                        <label for="user">Nom d\'utilisateur:</label><input type="text" name="user" required /><br>
                        <label for="pwd1">Mot de passe:</label><input type="password" name="pwd1" required /><br />
                        <label for="pwd2">Mot de passe (encore):</label><input type="password" name="pwd2" required /><br /><br />
                        <label for="nothing"></label><input name="nothing" type="submit" value="Ajouter l\'utilisateur" />
                    </form>
                    <br /><br /><h2>Supprimer un utilisateur</h2>
                    <table><thead><tr><td>Nom d\'utilisateur</td><td>Action</td></tr></thead><tbody>';
                    $query = $sqlite->query('SELECT id,username FROM users WHERE admin="0"');
                    while($response = $query->fetch()){
                        echo '<tr><td>' . $response['username'] . '</td><td><a href="misc.php?deluser=' . $response['id'] . '">Supprimer</a></td></tr>';
                    }
                    echo '</tbody></table></fieldset>';
                }
                echo '</article>'; 
            }
        ?>
    </body>
</html>