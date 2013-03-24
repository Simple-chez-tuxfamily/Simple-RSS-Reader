<?php
    if(!isset($_SESSION['id']) or !is_numeric($_SESSION['id']))
        exit;
        
    $sqlite = new PDO('sqlite:private/data.db');

    $sqlite->query('DELETE FROM items WHERE read="1" AND user_id="' . $_SESSION['id'] . '"');
    $sqlite->query('VACUUM'); 
?>