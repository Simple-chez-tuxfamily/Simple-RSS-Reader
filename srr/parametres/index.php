<?php
    session_start();       
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paramètres</title>
        <link type="text/css" rel="stylesheet" href="../themes/<?php echo $_SESSION['theme']; ?>/params.css" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php
            if(isset($_SESSION['uname'])){
                echo '<article><h1>Paramètres (<a href="../connexion/disconnect.php">déconnexion</a>)</h1><hr />
                <fieldset><legend>Mes flux suivis</legend><h2>Ajouter un flux</h2>
                <form action="feeds.php" method="get">
                    <label for="url" style="margin-right:-40px;">Adresse du flux à ajouter:</label><input type="url" name="url" required /><br /><br />
                    <label for="nothing" style="margin-right:-40px;"></label><input type="submit" value="Ajouter le flux" /></form>';
                $sqlite = new PDO('sqlite:../include/data.db');
                $query = $sqlite->query('SELECT id,url,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                $nbr = $sqlite->query('SELECT count(id) FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                $nbr = $nbr->fetch();
                if($nbr[0] > 0){
                    echo '<br /><br /><h2>Gérer le';
                    if($nbr[0] > 1){
                        echo 's ' . $nbr[0];
                    }
                    echo ' flux</h2><table><thead><tr><td>Nom du flux</td><td>Action</td></tr></thead><tbody>';
                    while($response = $query->fetch()){
                        echo '<tr><td><a href="' . $response['url'] . '">' . $response['title'] . '</a></td><td><a href="feeds.php?del=' . $response['id'] . '">Supprimer</a></td></tr>';
                    }
                    echo '</tbody></table>';
                }
                echo '</fieldset><br /><fieldset><legend>Mon compte</legend><h2>Thème</h2><table><thead><tr><td>Nom du thème</td><td>Action</td></tr></thead><tbody>';
                $repertoire = opendir('../themes');
                $nbrt = 0;
                while($contenu = readdir($repertoire)){
                    if(!is_dir($contenu) && $contenu != $_SESSION['theme']){
                        $nbrt++;
                        echo '<tr><td>' . $contenu . '</td><td><a href="user.php?theme=' . $contenu . '">Choisir</a></td></tr>';
                    }
                }
                if($nbrt == 0){
                    echo '<tr><td colspan="2">Aucun thème n\'est disponible...</td></tr>';
                }
                closedir($repertoire);
                echo '</tbody></table><br /><h2>Changer de mot de passe</h2>
                <form action="user.php" method="POST">
                    <label for="pwd1">Mot de passe actuel:</label><input type="password" name="pwd1" required /><br />
                    <label for="pwd2">Nouveau mot de passe:</label><input type="password" name="pwd2" required /><br />
                    <label for="pwd3">Nouveau mot de passe (encore):</label><input type="password" name="pwd3" required /><br /><br />
                    <label for="nothing"></label><input name="nothing" type="submit" value="Changer le mot de passe" />
                </form><h2>Paramètres divers</h2>
                <form action="user.php" method="GET"><table><thead><tr><td>Paramètre</td><td>Valeur</td></tr></thead><tbody>
                    <tr><td>Afficher tous les items non lu sur une <a href="../public/?id=' . $_SESSION['id'] . '">page publique</a>.</td><td style="text-align:center;"><input type="checkbox" name="public" /></td></tr>
                    <tr><td>Afficher tous les items non lu sur un <a href="../public/rss.php?id=' . $_SESSION['id'] . '">flux public</a>.</td><td style="text-align:center;"><input type="checkbox" name="lls" /></td></tr>
                    <tr><td>Lire les items directement sur leur site d\'origine.</td><td style="text-align:center;"><input type="checkbox" name="lls" /></td></tr>
                    </tbody></table><br /><input type="submit" value="Enregistrer les paramètres" />
                </form></fieldset>';
                if($_SESSION['admin'] == 1){
                    echo '<br /><fieldset><legend>Gestion des utilisateurs</legend><h2>Ajouter un utilisateur</h2>
                    <form action="users.php" method="POST">
                        <label for="user">Nom d\'utilisateur:</label><input type="text" name="user" required /><br />
                        <label for="pwd1">Mot de passe:</label><input type="password" name="pwd1" required /><br />
                        <label for="pwd2">Mot de passe (encore):</label><input type="password" name="pwd2" required /><br /><br />
                        <label for="nothing"></label><input name="nothing" type="submit" value="Ajouter l\'utilisateur" />
                    </form>';
                    $query = $sqlite->query('SELECT count(id) FROM users WHERE admin="0"');
                    $response = $query->fetch();
                    if($response[0] > 0){
                        echo'<br /><br /><h2>Supprimer un utilisateur</h2>
                        <table><thead><tr><td>Nom d\'utilisateur</td><td>Action</td></tr></thead><tbody>';
                        $query = $sqlite->query('SELECT id,username FROM users WHERE admin="0"');
                        while($response = $query->fetch()){
                            echo '<tr><td>' . $response['username'] . '</td><td><a href="users.php?deluser=' . $response['id'] . '">Supprimer</a></td></tr>';
                        }
                        echo '</tbody></table>';
                    }
                    echo '</fieldset>';
                }
                echo '</article><br />Pensez à vérifier la présence de mises à jour!'; 
            }
        ?>
    </body>
</html>