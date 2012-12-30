<?php
    if(!isset($_GET['id']) or !is_numeric($_GET['id']))
        die('Erreur: aucun id de flux n\'a été spécifié!');
    
    error_reporting(0);
    session_start();
    
    include '../include/simplepie.inc';
    
    $simple = new SimplePie();
    $simple->enable_cache(false);
    $simple->set_useragent('Mozilla/5.0 (compatible; SimplePie.org; github.com/quent1-fr/Simple-RSS-Reader)');
    
    $sqlite = new PDO('sqlite:../include/data.db');
    $query = $sqlite->query('SELECT url,last_check FROM feeds WHERE user_id="' . $_SESSION['id'] . '" AND id="' . $_GET['id'] . '"');
    
    $time = time();
    
    $response = $query->fetch();
    
    if($time > $response['last_check'] + 1200){
        $simple->set_feed_url($response['url']);
        $simple->init();
        $simple->handle_content_type();
        
        foreach($simple->get_items() as $item){
            $date = strtotime($item->get_date());
            if($date < $response['last_check'])
                break;
            
            $permalink = $sqlite->quote($item->get_permalink());
                
            $already_exist = $sqlite->query('SELECT count(id) AS nb_article FROM items WHERE permalink=' . $permalink);
            $already_exist = $already_exist->fetch();
            
            if(intval($already_exist['nb_article']) > 0)
                break;
            
            $title = $sqlite->quote(strip_tags($item->get_title()));
            
            $description = $sqlite->quote($item->get_content());
            if(empty($description))
                $description = $sqlite->quote($item->get_description());
            $description = preg_replace('@<script[^>]*?>.*?</script>@si', '', $description); // Protection sommaire contre les attaques XSS
            $description = str_replace('<a ', '<a target="_blank" ', $description);
                
            if($date == 0)
                $date = $time; 
            $date = $sqlite->quote($date);
                
            $maxid = $sqlite->query('SELECT max(id) FROM items');
            $maxid = $maxid->fetch();
            $maxid = $maxid[0] + 1;
                
            $sqlite->query('INSERT INTO items VALUES(' . $maxid . ',' . $_GET['id'] . ',' . $title . ',' . $permalink . ',' . $description . ',' . $date . ',\'0\',"' . $_SESSION['id'] . '")');
        }
        $sqlite->query('UPDATE feeds SET last_check=' . $sqlite->quote($time) . ' WHERE id=' . $sqlite->quote($_GET['id'])) or die(print_r($sqlite->errorInfo()));
    }

    $sqlite->query('DELETE FROM items WHERE read="1" AND user_id="' . $_GET['id'] . '"') or die(print_r($sqlite->errorInfo()));
    $sqlite->query('VACUUM'); 
?>