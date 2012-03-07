<?php
    include 'config.php';
    if(isset($_GET['connect'],$_POST['pseudo'],$_POST['password']) && $_POST['pseudo'] == $config['uname'] && sha1($_POST['pseudo'] . $_POST['password'] . $_POST['pseudo']) == $config['passwd']){
        session_start();
        $_SESSION['uname'] = $config['uname'];
        if(isset($_POST['keep'])){
            setcookie('is_connected', $config['uname'] . ';' . $config['passwd'], (time() + 2592000));
        }
    }
    elseif(isset($_GET['disconnect'])){
        session_start();
        session_destroy();
        setcookie('is_connected','',1);
    }
    header('Location: index.php');
?>