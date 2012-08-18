<?php
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');
    if(isset($_GET['url']) && !empty($_GET['url'])){
        include '../include/syndexport.php';
        $feed = file_get_contents($_GET['url']);
        $synd = new SyndExport($feed);
        $infos = $synd->exportInfos();
        $_GET['title'] = $infos['title'];
        if(!empty($_GET['title'])){
            $maxid = $sqlite->query('SELECT max(id) FROM feeds');
            $maxid = $maxid->fetch();
            $maxid = $maxid[0] + 1;
            $sqlite->query('INSERT INTO feeds VALUES(' . $maxid . ',' . $sqlite->quote(htmlentities($_GET['title'])) . ',' . $sqlite->quote($_GET['url']) . ',' . $sqlite->quote(time()) . ',"' . $_SESSION['id'] . '")');   
            header('Location: ../index.php?p=parametres&page=flux&msg=9');
        }
        else{
            header('Location: ../index.php?p=parametres&page=flux&msg=10');
        }
    }
    elseif(isset($_GET['del']) && is_numeric($_GET['del'])){
        $sqlite->query('DELETE FROM feeds WHERE id="' . $_GET['del'] . '"');
        $sqlite->query('DELETE FROM items WHERE feed_id="'.$_GET['del'].'"');
        header('Location: ../index.php?p=parametres&page=flux&msg=8');
    }
    else{
        header('Location: ../index.php?p=parametres&page=flux&msg=2');
    }
?>