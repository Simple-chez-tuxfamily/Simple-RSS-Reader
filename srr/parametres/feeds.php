<?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');
    if(isset($_GET['url']) && !empty($_GET['url'])){
        include '../include/simplepie.inc';
        $simple = new SimplePie();
        $simple->enable_cache(false);
        $simple->set_useragent('Mozilla/4.0 '.SIMPLEPIE_USERAGENT.' (with Simple RSS Reader)');
        $simple->set_feed_url($_GET['url']);
        $simple->init();
        $simple->handle_content_type();
        $_GET['title'] = $simple->get_title();
        $maxid = $sqlite->query('SELECT max(id) FROM feeds');
        $maxid = $maxid->fetch();
        $maxid = $maxid[0] + 1;
        $sqlite->query('INSERT INTO feeds VALUES(' . $maxid . ',' . $sqlite->quote($_GET['title']) . ',' . $sqlite->quote($_GET['url']) . ',' . $sqlite->quote(time()) . ',"' . $_SESSION['id'] . '")');   
    }
    elseif(isset($_GET['del']) && is_numeric($_GET['del'])){
        $sqlite->query('DELETE FROM feeds WHERE id="' . $_GET['del'] . '"');    
    }
    header('Location: index.php');
?>