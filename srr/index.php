<?php
    session_start();
    include 'config.php';
    if(!isset($_SESSION['uname']) && isset($_COOKIE['is_connected']) && $_COOKIE['is_connected'] == $config['uname'] . ';' . $config['passwd']){
        $_SESSION['uname'] = $config['uname'];
        header('Location: index.php');
    }
?>
<!DOCTYPE html><html><head><title>Simple RSS Reader</title><link rel="shortcut icon" type="image/png" href="favicon.png" /><link rel="apple-touch-icon" href="favicon.png" /><meta http-equiv=Content-Type content="text/html; charset=utf-8"><style type="text/css">body{font-family:Calibri, sans-serif;font-size:12px;background:#fafafa;margin:0;padding:0}#list{list-style:none;border-bottom:1px solid #ddd;margin:0;padding:0}ul#menu{background:#444;display:none}#list li{border-top:1px solid #ddd;padding:5px 10px}ul#menu li{border-top:1px solid #333}ul#menu li a{color:#fafafa;text-decoration:none;font-size:14px}.title{font-size:16px;margin:0;padding:0}h1 a{color:#333;text-decoration:none}.name{font-size:14px;color:#aaa;font-weight:lighter;margin:0;padding:5px 0 0}#content{padding:0 10px}article{display:block}hr{border:0;border-bottom:1px dashed #aaa;margin:15px 0}header{height:35px;line-height:35px;background:#111;font-size:23px;text-align:center;color:#eee;border-bottom:2px solid orange;}form{width:200px;text-align:center;background:#f9f9f9;border-radius:10px;line-height:20px;box-shadow:0 0 5px #aaa;margin:5px auto 15px;padding:10px}h1#titre{margin:0;padding:0;text-align:center;margin:10px 0;}#gauche{float:left;width:30%;border-right:1px dashed #aaa;}#droite{position:fixed;left:31%;top:40px;width:70%;}</style><script type="text/javascript">function click(){if(o==false){document.getElementById("menu").style.display="block";o=true}else{document.getElementById("menu").style.display="none";o=false}}var o=false;function resize(){ var taille = window.innerHeight - 40; document.getElementById("droite").style.height = taille.toString() + "px"; }</script><meta name=viewport content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"><body onload="resize();setTimeout(function() { window.scrollTo(0, 1) }, 100)"><?php
    if(!isset($_SESSION['uname'])){
        echo '<h1 id="titre">Connexion</h1><form action="misc.php?connect" method="post">Nom d\'utilisateur:<br /><input type="text" name="pseudo" required /><br />Mot de passe:<br /><input type="password" name="password" required /><br /><br /><input type="checkbox" name="keep" /> Garder la connexion active<br /><br /><input type="submit" value="Connexion" /></form>';
    }
    else{
        $sqlite = new PDO('sqlite:data.db');
        $result = $sqlite->query('SELECT count(id) FROM items WHERE read=\'0\'');
        $result = $result->fetch();
        if($result[0] > 0){
            $nothing = false;
        }
        else{
            $nothing = true;
        }
        if(!isset($_GET['frame'])){
            echo '<header onclick="click();">Simple RSS Reader';
            if(!$nothing){
                echo ' (' . $result[0] . ' non lus)';
            }
            echo '</header><ul id="menu"><li><a href="index.php">Retour à la page d\'accueil</a></li><li><a href="check.php">Mettre à jour les flux</a></li><li><a href="misc.php?disconnect">Déconnexion</a></li></ul>';
        }
        if(!isset($_GET['read']) or !is_numeric($_GET['read'])){
            if(!$nothing){
                echo '<div id="gauche"><ul id="list">';
                $query = $sqlite->query('SELECT id,title FROM feeds');
                while($response = $query->fetch()){ $name[$response['id']] = $response['title']; }
                $query = $sqlite->query('SELECT * FROM items WHERE read=\'0\' ORDER BY date DESC');
                while($response = $query->fetch()){ echo '<li><h1 class="title"><a target="apercu" href="?read=' . $response['id'] . '&frame">' . $response['title'] . '</a></h1><h2 class="name">' . $name[$response['feed_id']] . '</h2></li>'; }
                echo '</ul></div>';
                echo '<div id="droite"><iframe width="100%" height="100%" scrolling="auto" frameborder="0" src="?read=9999999999&frame" name="apercu"></iframe></div>';
            }
            else{
                echo '<p style="text-align:center;font-size:17px;">Il n\'y a rien à afficher...</p>';
            }
        }
        else{
            $query = $sqlite->query('SELECT * FROM items WHERE id=' . $sqlite->quote($_GET['read']));
            $response = $query->fetch();
            if(!empty($response['title'])){
                echo '<div id="content"><h1><a href="' . $response['permalink'] . '">' . $response['title'] . '</a></h1><em>Posté le ' . date('d/m/Y à G\hi\m',$response['date']) . '</em><hr /><article>' . $response['description'] . '</article></div>';
                $sqlite->query('UPDATE items SET read=\'1\' WHERE id=' . $sqlite->quote($_GET['read']));
            }
        }
    }
?></body></html>