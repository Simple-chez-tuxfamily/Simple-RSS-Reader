<?php
    $sqlite = new PDO('sqlite:include/data.db');
    
    if(isset($_GET['read']) && is_numeric($_GET['read']))
        $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['read']));
    
    elseif(isset($_GET['unread']) && is_numeric($_GET['unread']))
        $sqlite->query('UPDATE items SET read=\'0\' WHERE id=' . $sqlite->quote($_GET['unread']));
?>