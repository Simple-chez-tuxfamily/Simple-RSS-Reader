<?php
    if(!isset($_SESSION['id']) or !is_numeric($_SESSION['id']))
        exit;
        
    $sqlite = new PDO('sqlite:private/data.db');
    $sqlite->query('DELETE FROM items WHERE read="1" AND user_id="' . $_SESSION['id'] . '"'); // On supprime les items lus
    $sqlite->query('DELETE FROM items WHERE id in (SELECT id FROM items GROUP BY permalink, feed_id HAVING COUNT(permalink) >1 AND COUNT(feed_id) >1)'); // On supprime les doublons (un doublon = même id de flux et même lien)
    $sqlite->query('VACUUM'); 
?>