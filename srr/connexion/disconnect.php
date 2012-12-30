<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    $url = str_replace('connexion/disconnect.php','',$_SERVER['SCRIPT_NAME']); // Chemin du cookie
    setcookie('is_connected','',1,$url);
    header('Location: ../index.php');
?>