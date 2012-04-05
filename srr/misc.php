<?php
    include 'config.php';
    if(isset($_GET['connect'],$_POST['pseudo'],$_POST['password']) && $_POST['pseudo'] == $config['uname'] && sha1($_POST['pseudo'] . $_POST['password'] . $_POST['pseudo']) == $config['passwd']){
        session_start();
        $_SESSION['uname'] = $config['uname'];
        if(isset($_POST['keep'])){
            setcookie('is_connected', $config['uname'] . ';' . $config['passwd'], (time() + 2592000));
        }
        header('Location: index.php');
    }
    elseif(isset($_GET['disconnect'])){
        session_start();
        session_destroy();
        setcookie('is_connected','',1);
        header('Location: index.php');
    }
    elseif(isset($_GET['unread']) && is_numeric($_GET['unread'])){
        $sqlite = new PDO('sqlite:data.db');
        $sqlite->query('UPDATE items SET read="0" WHERE id="' . $_GET['unread'] . '"');    
        header('Location: index.php?read=' . $_GET['unread'] . '&frame&unread');
    }
    elseif(isset($_GET['title'],$_GET['url']) && !empty($_GET['title']) && !empty($_GET['url'])){
        $sqlite = new PDO('sqlite:data.db');
        $maxid = $sqlite->query('SELECT max(id) FROM feeds');
        $maxid = $maxid->fetch();
        $maxid = $maxid[0] + 1;
        $sqlite->query('INSERT INTO feeds VALUES(' . $maxid . ',' . $sqlite->quote($_GET['title']) . ',' . $sqlite->quote($_GET['url']) . ',\'0\')') or die($sqlite->errorInfo());   
        header('Location: params.php');
    }
    elseif(isset($_GET['del']) && is_numeric($_GET['del'])){
        $sqlite = new PDO('sqlite:data.db');
        $sqlite->query('DELETE FROM feeds WHERE id="' . $_GET['del'] . '"');    
        header('Location: params.php');
    }
?>