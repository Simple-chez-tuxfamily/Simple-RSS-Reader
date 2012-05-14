<?php
    session_start();
    if(file_exists('../installation/install.php')){
        header('Location: ../installation/index.php');
    }
    elseif(!isset($_SESSION['uname'])){
        header('Location: connexion/');
    }
    elseif(isset($_GET['mobile'])){
        $_SESSION['theme'] = 'mobile';
    }
    elseif(isset($_GET['desktop'])){
        $_SESSION['theme'] = 'defaut';
    }
    ob_start();
        $sqlite = new PDO('sqlite:include/data.db');
        $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
        $result = $result->fetch();
        $nonlu = $result[0];
        if(!isset($_GET['p']) or $_GET['p'] == 'index'){
            $page = 'style';
            include 'read.php';
        }
        elseif($_GET['p'] == 'parametres'){
            $page = 'params';
            include 'parametres/index.php';
        }
        else{
            die('<h1>Erreur 404</h1><p>La page demand&eacute;e est introuvable!</p>');
        }
        $content = ob_get_contents();
    ob_end_clean();
    include './themes/' . $_SESSION['theme'] . '/template.php';
?>