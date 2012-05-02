<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    setcookie('is_connected','',1);
    header('Location: ../index.php');
?>