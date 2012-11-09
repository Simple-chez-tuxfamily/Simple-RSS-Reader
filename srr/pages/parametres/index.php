<?php
    $title = 'Paramètres';
    
    if(!isset($_SESSION['uname'])) exit(0);
    if(!isset($_GET['page']))      $_GET['page'] = 'flux';
    if(!isset($_GET['msg']))       $_GET['msg'] = -1;
    
    switch($_GET['page']){
        case 'flux':         echo '<h1>Flux suivis</h1>'; break;
        case 'compte':       echo '<h1>Mon compte</h1>'; break;
        case 'utilisateurs': echo '<h1>Gestion des utilisateurs</h1>'; break;
    }

    switch($_GET['msg']){
        case 0:  echo '<div class="message erreur">Erreur lors de l\'importation. Le fichier est probablement invalide.</div>'; break;
        case 1:  echo '<div class="message confirmation">L\'importation a été effectuée avec succès.</div>'; break;
        case 2:  echo '<div class="message erreur">Une erreur inconnue s\'est produite.</div>'; break;
        case 3:  echo '<div class="message confirmation">Le mot de passe a été changé avec succès.</div>'; break;
        case 4:  echo '<div class="message erreur">Mauvais mot de passe ou les deux mots de passe ne correspondent pas!</div>'; break;
        case 5:  echo '<div class="message confirmation">Le thème a été changé avec succès.</div>'; break;
        case 6:  echo '<div class="message confirmation">L\'utilisateur a été supprimé avec succès.</div>'; break;
        case 7:  echo '<div class="message confirmation">L\'utilisateur a été ajouté avec succès.</div>'; break;
        case 8:  echo '<div class="message confirmation">Le flux a été supprimé avec succès.</div>'; break;
        case 9:  echo '<div class="message confirmation">Le flux a été ajouté avec succès.</div>'; break;
        case 10: echo '<div class="message erreur">Le flux n\'existe pas ou ne comporte pas de titre!</div>'; break;
    }
    
    switch($_GET['page']){
        case 'flux':
            echo '<h2>Ajouter un flux</h2><form action="parametres/feeds.php" method="get"><label for="url">Adresse du flux à ajouter:</label><input type="url" name="url" required /><input type="submit" value="Ajouter le flux" /></form>';
            echo '<h2>Importer un flux (.opml et .xml uniquement)</h2><form action="parametres/import.php" method="post" enctype="multipart/form-data"><label for="file">Fichier à importer:</label><input type="file" name="file"/><input type="submit" name="submit" value="Importer" /></form>';
            echo '<h2>Exporter mes flux</h2><p><a href="parametres/export.php">Cliquez ici</a> pour exporter vos flux.</p>';
            
            $nbr = $sqlite->query('SELECT count(id) FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
            $nbr = $nbr->fetch();
            
            if($nbr[0] > 0){
                echo '<h2>Gérer le'; if($nbr[0] > 1) echo 's ' . $nbr[0]; echo ' flux</h2><table><tr><th>Nom du flux</th><th>Action</th></tr></thead><tbody>';
                $query = $sqlite->query('SELECT id,url,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
                while($response = $query->fetch()) echo '<tr><td><a href="' . $response['url'] . '">' . $response['title'] . '</a></td><td><a href="parametres/feeds.php?del=' . $response['id'] . '">Supprimer</a></td></tr>';
                echo '</tbody></table>';
            }
            break;
        case 'compte':
            echo '<h2>Thème</h2><table><thead><tr><td>Nom du thème</td><td>Action</td></tr></thead><tbody>';
            $repertoire = opendir('themes');
            $nbrt = 0;
            while($contenu = readdir($repertoire)){
                if(!is_dir($contenu) && $contenu != $_SESSION['theme'] && $contenu != 'mobile'){
                    $nbrt++;
                    echo '<tr><td>' . $contenu . '</td><td><a href="parametres/user.php?theme=' . $contenu . '">Choisir</a></td></tr>';
                }
            }
            if($nbrt == 0) echo '<tr><td colspan="2">Aucun thème n\'est disponible...</td></tr>';
            closedir($repertoire);
            echo '</tbody></table><br /><h2>Changer de mot de passe</h2>
                <form action="parametres/user.php" method="POST">
                    <label for="pwd1">Mot de passe actuel:</label><input type="password" name="pwd1" required /><br />
                    <label for="pwd2">Nouveau mot de passe:</label><input type="password" name="pwd2" required /><br />
                    <label for="pwd3">Nouveau mot de passe (encore):</label><input type="password" name="pwd3" required /><br /><br />
                    <label for="nothing"></label><input name="nothing" type="submit" value="Changer le mot de passe" />
                </form>';
            break;
        case 'utilisateurs':
            if($_SESSION['admin'] == 1){
                echo '<h2>Ajouter un utilisateur</h2>
                <form action="parametres/users.php" method="POST">
                    <label for="user">Nom d\'utilisateur:</label><input type="text" name="user" required /><br />
                    <label for="pwd1">Mot de passe:</label><input type="password" name="pwd1" required /><br />
                    <label for="pwd2">Mot de passe (encore):</label><input type="password" name="pwd2" required /><br /><br />
                    <label for="nothing"></label><input name="nothing" type="submit" value="Ajouter l\'utilisateur" />
                </form>';
                
                $query = $sqlite->query('SELECT count(id) FROM users WHERE admin="0"');
                $response = $query->fetch();
                if($response[0] > 0){
                    echo'<br /><br /><h2>Supprimer un utilisateur</h2><table><thead><tr><td>Nom d\'utilisateur</td><td>Action</td></tr></thead><tbody>';
                    $query = $sqlite->query('SELECT id,username FROM users WHERE admin="0"');
                    while($response = $query->fetch()) echo '<tr><td>' . $response['username'] . '</td><td><a href="parametres/users.php?deluser=' . $response['id'] . '">Supprimer</a></td></tr>';
                    echo '</tbody></table>';
                }    
            }
            else echo '<p>Vous n\'êtes pas autorisé à accéder à cette page!</p>';
            break;
    }
?>