<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/<?php echo $_SESSION['theme']; ?>/style.css" />
        <link rel="shortcut icon" type="image/png" href="themes/<?php echo $_SESSION['theme']; ?>/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
    <?php
        if(isset($_SESSION['uname'],$_GET['read']) && is_numeric($_GET['read'])){
            $sqlite = new PDO('sqlite:include/data.db');
            $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
            $response = $query->fetch();
            if(!empty($response['title'])){
                echo '<article><h1><a href="' . $response['permalink'] . '">' . $response['title'] . '</a></h1><span id="infos">Posté le ' . date('d/m/Y à G\hi\m',$response['date']) . '. <a onclick="parent.frames[\'top\'].document.getElementById(\'i' . $response['id'] . '\').style.fontWeight = \'bold\'" style="color:#888;text-decoration:none;font-weight:bold;" href="read.php?read=' . $_GET['read'] . '&unread">Marquer comme non lu</a></span><hr />' . $response['description'] . '</article><hr style="visibility:hidden;"/><br style="visibility:hidden;" /><hr style="visibility:hidden;" />';
                if(!isset($_GET['unread'])){
                    $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
                }
                else{
                    $sqlite->query('UPDATE items SET read=\'0\' WHERE id=' . $sqlite->quote($_GET['read']) . ' AND user_id="' . $_SESSION['id'] . '"');
                }
            }
        }
    ?>
    </body>
</html>