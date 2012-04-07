<?php
    set_time_limit(0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    include 'simplepie.inc';
    include 'config.php';
    $config['verif_time'] = $config['verif_time'] * 60;
    $simple = new SimplePie();
    $simple->enable_cache(false);
    $simple->set_useragent('Mozilla/4.0 '.SIMPLEPIE_USERAGENT);
    $sqlite = new PDO('sqlite:data.db');
    $sqlite->query('DELETE FROM items WHERE read=\'1\'');
    $sqlite->query('VACUUM');
    $query = $sqlite->query('SELECT id,url FROM feeds');
    while($response = $query->fetch()){
        $ddate = $sqlite->query('SELECT last_check FROM feeds WHERE id=' . $sqlite->quote($response['id']));
        $ddate = $ddate->fetch();
        $ddate = $ddate[0];
        if(time() > $ddate + $config['verif_time']){
            $simple->set_feed_url($response['url']);
            $simple->init();
            $simple->handle_content_type();
            foreach($simple->get_items() as $item){
                $maxid = $sqlite->query('SELECT max(id) FROM items');
                $maxid = $maxid->fetch();
                $maxid = $maxid[0] + 1;
                $permalink = $sqlite->quote($item->get_permalink());
                $title = $sqlite->quote($item->get_title());
                $description = $sqlite->quote($item->get_content());
                if(empty($description)){
                    $description = $sqlite->quote($item->get_description());
                }
                $date = strtotime($item->get_date());
                if($date < $ddate){ break; }
                else{
                    $date = $sqlite->quote($date);
                    $sqlite->query('INSERT INTO items VALUES(' . $maxid . ',' . $response['id'] . ',' . $title . ',' . $permalink . ',' . $description . ',' . $date . ',\'0\')');   
                }
            }
            $sqlite->query('UPDATE feeds SET last_check=' . $sqlite->quote(time()) . ' WHERE id=' . $sqlite->quote($response['id']));
        }
    }
    header('Location: index.php');
?>