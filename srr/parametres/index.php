<?php
    $title = 'Paramètres';
            if(isset($_SESSION['uname'])){
                echo '<nav id="parametres"><ul>
                    <li><a href="?p=parametres&page=flux">Mes flux suivis</a></li>
                    <li><a href="?p=parametres&page=compte">Mon compte</a></li>
                    <li><a href="?p=parametres&page=impexp">Importer/exporter mes flux</a></li>';
                if($_SESSION['admin'] == 1){
                    echo '<li><a href="?p=parametres&page=utilisateurs">Gestion des utilisateurs</a></li>
                    <li><a href="?p=parametres&page=maj">Vérifier la présence d\'une mise à jour</a></li>';
                }    
                echo '</ul></nav><article><div class="article_content">';
                if(!isset($_GET['page'])){
                    echo '<h1>Paramètres</h1>';
                }
                else{
                    echo '<h1>';
                    switch($_GET['page']){
                        case 'flux':
                            echo 'Mes flux suivis';
                            break;
                        case 'compte':
                            echo 'Mon compte';
                            break;
                        case 'utilisateurs':
                            echo 'Gestion des utilisateurs';
                            break;
                        case 'maj':
                            echo 'Vérifier la présence d\'une mise à jour';
                            break;
                        case 'impexp':
                            echo 'Importer/exporter mes flux';
                            break;
                    }
                    echo '</h1>';
                }
                echo '<hr />';
                if(isset($_GET['msg'])){
                    echo '<script type="text/javascript">document.body.onload = function() {';
                    switch($_GET['msg']){
                        case 0:
                            echo 'afficher_message("problème lors de l\'importation. Le fichier est probablement invalide.", 5, 0);';
                            break;
                        case 1:
                            echo 'afficher_message("L\'importation a été effectuée avec succès.", 5, 1);';
                            break;
                        case 2:
                            echo 'afficher_message("une erreur inconnue s\'est produite.", 5, 0);';
                            break;
                        case 3:
                            echo 'afficher_message("Le mot de passe a été changé avec succès.", 5, 1);';
                            break;
                        case 4:
                            echo 'afficher_message("mauvais mot de passe ou les deux mots de passe ne correspondent pas!", 5, 0);';
                            break;
                        case 5:
                            echo 'afficher_message("Le thème a été changé avec succès.", 5, 1);';
                            break;
                        case 6:
                            echo 'afficher_message("L\'utilisateur a été supprimé avec succès.", 5, 1);';
                            break;
                        case 7:
                            echo 'afficher_message("L\'utilisateur a été ajouté avec succès.", 5, 1);';
                            break;
                        case 8:
                            echo 'afficher_message("Le flux a été supprimé avec succès.", 5, 1);';
                            break;
                        case 9:
                            echo 'afficher_message("Le flux a été ajouté avec succès.", 5, 1);';
                            break;
                        case 5:
                            echo 'afficher_message("Le flux n\'existe pas ou ne comporte pas de titre!", 5, 0);';
                            break;
                    }
                    echo '}</script>';
                }
                if(!isset($_GET['page'])){
                    echo '<p>Cliquez sur une rubrique pour éditer vos paramètres.</p>';
                }
                else{
                    switch($_GET['page']){
                        case 'flux':
                            echo '<h2>Ajouter un flux</h2>
                                <form action="parametres/feeds.php" method="get">
                                    <input type="url" name="url" required placeholder="Adresse du flux à ajouter..." />
                                    <input type="submit" value="Ajouter le flux" /></form>';                
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
                                        echo '<tr><td><a href="' . $response['url'] . '">' . $response['title'] . '</a></td><td><a href="parametres/feeds.php?del=' . $response['id'] . '">Supprimer</a></td></tr>';
                                    }
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
                                if($nbrt == 0){
                                    echo '<tr><td colspan="2">Aucun thème n\'est disponible...</td></tr>';
                                }
                                closedir($repertoire);
                                echo '</tbody></table><br /><h2>Changer de mot de passe</h2>
                                <form action="parametres/user.php" method="POST">
                                    <input type="password" placeholder="Mot de passe actuel..." name="pwd1" required />
                                    <input type="password" placeholder="Nouveau mot de passe..." name="pwd2" required />
                                    <input type="password" placeholder="Nouveau mot de passe (encore)..." name="pwd3" required />
                                    <input name="nothing" type="submit" value="Changer le mot de passe" />
                                </form>';
                            break;
                        case 'utilisateurs':
                            if($_SESSION['admin'] == 1){
                                echo '<br /><h2>Ajouter un utilisateur</h2>
                                <form action="parametres/users.php" method="POST">
                                    <input type="text" name="user" placeholder="Nom d\'utilisateur..." required />
                                    <input type="password" placeholder="Mot de passe..." name="pwd1" required />
                                    <input type="password" placeholder="Mot de passe (encore)..." name="pwd2" required />
                                    <input name="nothing" type="submit" value="Ajouter l\'utilisateur" />
                                </form>';
                                $query = $sqlite->query('SELECT count(id) FROM users WHERE admin="0"');
                                $response = $query->fetch();
                                if($response[0] > 0){
                                    echo'<br /><br /><h2>Supprimer un utilisateur</h2>
                                    <table><thead><tr><td>Nom d\'utilisateur</td><td>Action</td></tr></thead><tbody>';
                                    $query = $sqlite->query('SELECT id,username FROM users WHERE admin="0"');
                                    while($response = $query->fetch()){
                                        echo '<tr><td>' . $response['username'] . '</td><td><a href="parametres/users.php?deluser=' . $response['id'] . '">Supprimer</a></td></tr>';
                                    }
                                    echo '</tbody></table>';
                                }
                            }
                            else{
                                echo '<p>Vous n\'êtes pas autorisé à accéder à cette page!</p>';
                            }
                            break;
                        case 'maj':
                            if($_SESSION['admin'] == 1){
                                $version_locale = 2.0; // Numéro de version de l'instance locale
                                $derniere_version_stable = file_get_contents('http://quent1-fr.github.com/Simple-RSS-Reader/version.srr'); // Numéro de version de la dernière version stable
                                if($derniere_version_stable > $version_locale)
                                    echo '<p>La version ' . $derniere_version_stable . ' est disponible. <a href="https://github.com/quent1-fr/Simple-RSS-Reader/zipball/master">Cliquez ici</a> pour la télécharger</p>';
                                elseif($derniere_version_stable < $version_locale)
                                    echo '<p>Votre version de Simple RSS Reader est déjà la plus récente.</p><p><strong>Attention:</strong> Vous utilisez une version de développement. Faites bien attention et n\'oubliez pas de <a href="https://github.com/quent1-fr/Simple-RSS-Reader/issues" target="_blank">signaler les éventuels bugs</a> que vous pourriez rencontrer!</p>';
                                else
                                    echo '<p>Votre version de Simple RSS Reader est déjà la plus récente.</p>';
                            }
                            else
                                echo '<p>Vous n\'êtes pas autorisé à accéder à cette page!</p>';
                            break;
                        case 'impexp':
                            echo '<h2>Importer un flux (fichier .opml ou .xml)</h2>
                                <form action="parametres/import.php" method="post" enctype="multipart/form-data">
                                    Fichier à importer: <input type="file" name="file"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="Importer" />
                                <h2>Exporter les flux</h2>
                                <p><a href="parametres/export.php" title="Exporter les flux">Cliquez ici</a> pour exporter vos flux.</p>
                                </form>';
                            break;
                    }
                }
                echo '</div></article>';
            }
        ?>
    </body>
</html>