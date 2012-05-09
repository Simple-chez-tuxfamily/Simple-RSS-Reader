<?php
    session_start();
    if(isset($_GET['pseudo'],$_GET['password'])){
        $sqlite = new PDO('sqlite:../include/data.db');
        if(empty($_GET['cookie'])) $_GET['password'] = $sqlite->quote(sha1($_GET['pseudo'] . $_GET['password'] . $_GET['pseudo']));
        else $_GET['password'] = $sqlite->quote($_GET['password']);
        $_GET['pseudo'] = $sqlite->quote($_GET['pseudo']);
        $query = $sqlite->query('SELECT * FROM users WHERE username=' . $_GET['pseudo'] . ' AND password=' . $_GET['password']);
        $result = $query->fetch();
        if(isset($result['id'])){
            $_SESSION['id'] = $result[0];
            $_SESSION['uname'] = $result[1];
            $_SESSION['admin'] = $result[3];
            $_SESSION['theme'] = $result[4];
            if(isset($_GET['keep'])){
                setcookie('is_connected', $result[1] . ';' . $result[2], (time() + 2592000));
            }
        }
        else{
            setcookie('is_connected','',1);
        }
    }
    header('Location: ../index.php');
?>