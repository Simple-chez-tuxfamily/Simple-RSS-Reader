<?php
    session_start();
    if(isset($_GET['unread']) && is_numeric($_GET['unread'])){
        $sqlite = new PDO('sqlite:include/data.db');
        $sqlite->query('UPDATE items SET read="0" WHERE id="' . $_GET['unread'] . '"');    
        header('Location: index.php?read=' . $_GET['unread'] . '&frame&unread');
    }
    else{
        header('Location: index.php');
    }
?>