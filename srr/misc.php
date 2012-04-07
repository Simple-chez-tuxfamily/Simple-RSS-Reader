<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
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
    elseif(isset($_GET['url']) && !empty($_GET['url'])){
        $sqlite = new PDO('sqlite:data.db');
        include 'simplepie.inc';
        $simple = new SimplePie();
        $simple->enable_cache(false);
        $simple->set_useragent('Mozilla/4.0 '.SIMPLEPIE_USERAGENT);
        $simple->set_feed_url($_GET['url']);
        $simple->init();
        $simple->handle_content_type();
        $_GET['title'] = $simple->get_title();
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
    else{
        header('Location: index.php');
    }
?>