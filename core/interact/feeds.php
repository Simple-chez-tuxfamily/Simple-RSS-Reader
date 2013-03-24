<?php
    $sqlite = new PDO('sqlite:private/data.db');
    if(isset($_GET['url']) && !empty($_GET['url'])){
        $testfeed = $sqlite->query('SELECT id FROM feeds WHERE url=' . $sqlite->quote($_GET['url']) . ' AND user_id="' . $_SESSION['id'] . '"');
        $testfeed = $testfeed->fetch();
        
        if(!isset($testuser['id'])){            
            include 'private/simplepie.php';
            $simple = new SimplePie();
            $simple->enable_cache(false);
            $simple->set_useragent('Mozilla/5.0 (compatible; SimplePie.org; simple.tuxfamily.org)');
            $simple->set_feed_url($_GET['url']);
            $simple->init();
            $simple->handle_content_type();
            $_GET['title'] = $simple->get_title();
            if(!empty($_GET['title'])){
                $sqlite->query('INSERT INTO feeds (title,url,last_check,user_id,error) VALUES(' . $sqlite->quote(htmlentities($_GET['title'])) . ',' . $sqlite->quote($_GET['url']) . ',' . $sqlite->quote(time()) . ',"' . $_SESSION['id'] . '","0")');
                header('Location: ../index.php?p=parametres&page=flux&msg=9');
            }
            else
                header('Location: ../index.php?p=parametres&page=flux&msg=10');
        }
        else
            header('Location: ../index.php?p=parametres&page=flux&msg=11');
    }
    elseif(isset($_GET['del']) && is_numeric($_GET['del'])){
        $sqlite->query('DELETE FROM feeds WHERE id=' .  $sqlite->quote($_GET['del']));
        $sqlite->query('DELETE FROM items WHERE feed_id=' .  $sqlite->quote($_GET['del']));
        header('Location: ../index.php?p=parametres&page=flux&msg=8');
    }
    else
        header('Location: ../index.php?p=parametres&page=flux&msg=2');
?>