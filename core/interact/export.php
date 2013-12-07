<?php 
    /* SQLite3 */
    $sqlite = new PDO('sqlite:private/data.db');
    $query = $sqlite->query('SELECT id,url,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');
    
    /* OPML Header & Footer */
    $head = '<?xml version="1.0" encoding="UTF-8"?>
    <opml version="1.0">
            <head>
                    <title>Flux de ' . $_SESSION['uname'] . '</title>
            </head>
            <body>';
    $foot = '</body></opml>';
    
    $feeds = '';
    while($feed = $query->fetch())
            $feeds .= '		<outline text="'.htmlspecialchars($feed['title']).'" title="'.htmlspecialchars($feed['title']).'" type="rss" xmlUrl="' . $feed['url'] . '" htmlUrl="' . $feed['url'] . '"/>' . "\n";
    
            
    header('Content-Type: application/force-download; name="flux_' . $_SESSION['uname'] . '.opml"');
    header('Content-Transfer-Encoding: binary'); 
    header('Expires: 0'); 
    header('Cache-Control: no-cache, must-revalidate'); 
    header('Pragma: no-cache');
    header('Content-Length: ' . strlen($head . $feeds . $foot)); 
    header('Content-Disposition: attachment; filename="flux_' . $_SESSION['uname'] . '.opml"');
    echo $head . $feeds . $foot;
?>