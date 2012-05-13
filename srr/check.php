<?php
    if(!isset($_GET['id']) or !is_numeric($_GET['id'])){ die('Erreur: aucun id n\'a été spécifié!'); }
    set_time_limit(0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    include 'include/simplepie.inc';
    $simple = new SimplePie();
    $simple->enable_cache(false);
    $simple->set_useragent('Mozilla/4.0 '.SIMPLEPIE_USERAGENT.' (with Simple RSS Reader)');
    $sqlite = new PDO('sqlite:include/data.db');
    $query = $sqlite->query('SELECT id,url,last_check FROM feeds WHERE user_id="' . $_GET['id'] . '"');
    $time = time();
    while($response = $query->fetch()){
        if($time > $response['last_check'] + 1200){
            $simple->set_feed_url($response['url']);
            $simple->init();
            $simple->handle_content_type();
            foreach($simple->get_items() as $item){
                $date = strtotime($item->get_date());
                if($date < $response['last_check']){ break; }
                $permalink = $sqlite->quote($item->get_permalink());
                $already_exist = $sqlite->query('SELECT count(id) AS nb_article FROM items WHERE permalink=' . $permalink);
                $already_exist = $already_exist->fetch();
                if(intval($already_exist['nb_article']) > 0){ break; }
                $title = $sqlite->quote($item->get_title());
                $description = $sqlite->quote($item->get_content());
                if(empty($description)){ $description = $sqlite->quote($item->get_description()); }
                if($date == 0){ $date = $time; }
                $date = $sqlite->quote($date);
                $maxid = $sqlite->query('SELECT max(id) FROM items');
                $maxid = $maxid->fetch();
                $maxid = $maxid[0] + 1;
                $description = preg_replace('/<script\b/i', '<div class="xss">', $description);
                $description = preg_replace('/<\/script>\b/i', '</div>', $description);
                $description = preg_replace('/on([a-z]+)/i', '', $description);
                $sqlite->query('INSERT INTO items VALUES(' . $maxid . ',' . $response['id'] . ',' . $title . ',' . $permalink . ',' . $description . ',' . $date . ',\'0\',"' . $_GET['id'] . '")');
            }
            $sqlite->query('UPDATE feeds SET last_check=' . $sqlite->quote($time) . ' WHERE id=' . $sqlite->quote($response['id']));
        }
    }
    $sqlite->query('DELETE FROM items WHERE read="1" AND user_id="' . $_GET['id'] . '"');
    $sqlite->query('VACUUM');
    header('Location: index.php');
?>