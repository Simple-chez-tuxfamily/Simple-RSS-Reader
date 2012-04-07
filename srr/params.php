<?php
    session_start();
    include 'config.php';        
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Paramètre</title>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $config['theme']; ?>/style.css" />
        <link rel="shortcut icon" type="image/png" href="favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
        <?php
            if(isset($_SESSION['uname'])){
                echo '<article><h1>Paramètres (<a href="misc.php?disconnect">déconnexion</a>)</h1><hr />
                <h2>Ajouter un flux</h2>
                <form action="misc.php" method="get">
                    Adresse du flux: <input type="url" name="url" required/> <input type="submit" value="Ajouter" /></form>';
                $sqlite = new PDO('sqlite:data.db');
                $query = $sqlite->query('SELECT id,url,title FROM feeds');
                $nbr = $sqlite->query('SELECT count(id) FROM feeds');
                $nbr = $nbr->fetch();
                echo '<br /><br /><h2>Gérer les ' . $nbr[0] . ' flux</h2><table><thead><tr><td>Nom du flux</td><td>Action</td></tr></thead><tbody>';
                while($response = $query->fetch()){ echo '<tr><td><a href="' . $response['url'] . '">' . $response['title'] . '</a></td><td><a href="misc.php?del=' . $response['id'] . '">Supprimer</a></td></tr>'; }
                echo'</tbody></table><hr /><a href="https://github.com/quent1-fr/Simple-RSS-Reader">https://github.com/quent1-fr/Simple-RSS-Reader</a></article>'; 
            }
        ?>
    </body>
</html>