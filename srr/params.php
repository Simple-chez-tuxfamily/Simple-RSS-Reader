<?php
    session_start();
    include 'config.php';
    if(isset($_SESSION['uname'])){
        echo '<style type="text/css">' . file_get_contents('themes/' . $config['theme'] . '/style.css') . '</style>
        <article><h1>Param&egrave;tres (<a href="misc.php?disconnect">d&eacute;connexion</a>)</h1><hr />
        <h2>Ajouter un flux</h2>
        <form action="misc.php" method="get">
            Nom du flux: <input type="text" name="title" /><br />
            Adresse du flux: <input type="url" name="url" /><br /><br />
            <input type="submit" value="Ajouter" />
        </form><br /><br /><h2>G&eacute;rer les flux</h2><table><thead><tr><td>Nom du flux</td><td>Action</td></tr></thead><tbody>';
        $sqlite = new PDO('sqlite:data.db');
        $query = $sqlite->query('SELECT id,title FROM feeds');
        while($response = $query->fetch()){ echo '<tr><td>' . $response['title'] . '</td><td><a href="misc.php?del=' . $response['id'] . '">Supprimer</a></td></tr>'; }
        echo'</tbody></table><hr /><a href="https://github.com/quent1-fr/Simple-RSS-Reader">https://github.com/quent1-fr/Simple-RSS-Reader</a></article>'; 
    }
?>