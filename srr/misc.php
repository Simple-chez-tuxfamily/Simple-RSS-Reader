<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    include 'config.php';
    session_start();
    if(isset($_GET['connect'],$_POST['pseudo'],$_POST['password'])){
        $sqlite = new PDO('sqlite:data.db');
        $_POST['password'] = $sqlite->quote(sha1($_POST['pseudo'] . $_POST['password'] . $_POST['pseudo']));
        $_POST['pseudo'] = $sqlite->quote($_POST['pseudo']);
        $query = $sqlite->query('SELECT * FROM users WHERE username=' . $_POST['pseudo'] . ' AND password=' . $_POST['password']);
        $result = $query->fetch();
        if(!empty($result[0])){
            $_SESSION['id'] = $result[0];
            $_SESSION['uname'] = $result[1];
            $_SESSION['admin'] = $result[3];
            if(isset($_POST['keep'])){
                setcookie('is_connected', $result[0] . ';' . $result[1] . ';' . $result[2] . ';' . $result[3], (time() + 2592000));
            }
        }
        header('Location: index.php');
    }
    elseif(isset($_GET['disconnect'])){
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
        $sqlite->query('INSERT INTO feeds VALUES(' . $maxid . ',' . $sqlite->quote($_GET['title']) . ',' . $sqlite->quote($_GET['url']) . ',\'0\')');   
        header('Location: params.php');
    }
    elseif(isset($_GET['del']) && is_numeric($_GET['del'])){
        $sqlite = new PDO('sqlite:data.db');
        $sqlite->query('DELETE FROM feeds WHERE id="' . $_GET['del'] . '"');    
        header('Location: params.php');
    }
    elseif(isset($_GET['adduser'],$_POST['user'],$_POST['pwd1'],$_POST['pwd2']) && $_SESSION['admin'] == 1){
        if($_POST['pwd1'] == $_POST['pwd2']){
            $sqlite = new PDO('sqlite:data.db');
            $maxid = $sqlite->query('SELECT max(id) FROM users');
            $maxid = $maxid->fetch();
            $maxid = $maxid[0] + 1;
            $user = $sqlite->quote($_POST['user']);
            $pass = $sqlite->quote(sha1($_POST['user'] . $_POST['pwd1'] . $_POST['user']));
            $sqlite->query('INSERT INTO users VALUES(' . $maxid . ',' . $user . ',' . $pass . ',"0")') or die(print_r($sqlite->errorInfo()));   
        }
        header('Location: params.php');
    }
    elseif(isset($_GET['deluser']) && is_numeric($_GET['deluser']) && $_SESSION['admin'] == 1){
        $sqlite = new PDO('sqlite:data.db');
        $sqlite->query('DELETE FROM users WHERE id="' . $_GET['deluser'] . '"');    
        header('Location: params.php');
    }
    else{
        header('Location: index.php');
    }
?>