<?php
    if(!isset($_GET['uid']) or !is_numeric($_GET['uid']))
        die('Erreur: aucun id n\'a été spécifié!');
        
    set_time_limit(0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        
    include 'core/private/simplepie.php';
    
    $simple = new SimplePie();
    
    $simple->enable_cache(false);    
    $simple->set_useragent('Mozilla/5.0 (compatible; SimplePie.org; simple.tuxfamily.org)');
    
    $sqlite = new PDO('sqlite:core/private/data.db');
    $query = $sqlite->query('SELECT id,url,last_check FROM feeds WHERE user_id=' . $sqlite->quote($_GET['uid']));
    $time = time();
    
    while($response = $query->fetch()){
        if($time > $response['last_check'] + 600){
            $feed_id = $response['id'];
            
            $simple->set_feed_url($response['url']);
            $simple->init();
            $simple->handle_content_type();
                
            $error = 0;
            if($simple->error())
                $error = 1;
            
            foreach($simple->get_items() as $item){
                $title = $sqlite->quote(strip_tags($item->get_title()));
                $permalink = $sqlite->quote($item->get_permalink());
                $date = strtotime($item->get_date());
                
                if($date < $response['last_check'] - 3600) // Si l'item lu date d'une heure avant la dernière recherche, on stoppe
                    break;
                
                $description = $sqlite->quote($item->get_content());
                if(empty($description))
                    $description = $sqlite->quote($item->get_description());
                
                $description = preg_replace('/(<(link|script|iframe|object|applet|embed).*?>[^<]*(<\/(link|script|iframe|object|applet|embed).*?>)?)/i', '', $description); // anti xss
                $description = preg_replace('/(script:)|(expression\()/i', '\\1&nbsp;', $description); // anti xss
                $description = preg_replace('/(onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onreset|onselect|onsubmit|onunload)=?/i', '', $description); // anti xss
                $description = str_replace('<a ', '<a target="_blank" ', $description);
                    
                if($date == 0)
                    $date = $time; 
                $date = $sqlite->quote($date);
                
                $sqlite->query('INSERT INTO items (feed_id,user_id,title,permalink,description,date,read) VALUES("' . $feed_id . '",' . $sqlite->quote($_GET['uid']) . ',' . $title . ',' . $permalink . ',' . $description . ',' . $date . ',"0")');
            }
            if($error == 0)
                $sqlite->query('UPDATE feeds SET last_check=' . $sqlite->quote($time) . ', error="0" WHERE id="' . $feed_id . '"');
            else
                $sqlite->query('UPDATE feeds SET error="1" WHERE id="' . $feed_id . '"');
        }
    }
    
    $sqlite->query('DELETE FROM items WHERE read="1" AND user_id="' . $_SESSION['id'] . '"'); // On supprime les items lus
    $sqlite->query('DELETE FROM items WHERE id in (SELECT id FROM items GROUP BY permalink, feed_id HAVING COUNT(permalink) >1 AND COUNT(feed_id) >1)'); // On supprime les doublons (un doublon = même id de flux et même lien)
    $sqlite->query('VACUUM'); 
    
    header('Location: http://' . $_SERVER['HTTP_HOST'] . str_replace('cron.php?uid=' . $_GET['uid'], '', $_SERVER['REQUEST_URI']));
?>