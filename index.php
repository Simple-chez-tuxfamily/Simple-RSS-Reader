<?php
    session_start();

    if(file_exists('installation/install.php'))
        header('Location: installation/index.php');
        
    ob_start();
        if(isset($_SESSION['uname'])){
            $sqlite = new PDO('sqlite:core/private/data.db');
            $result = $sqlite->query('SELECT count(id) FROM items WHERE read="0" AND user_id="' . $_SESSION['id'] . '"');
            $result = $result->fetch();
            $nonlu = $result[0];
        
            if(!isset($_GET['p']))
                $_GET['p'] = 'lire';
            if(!file_exists('pages/' . $_GET['p'] . '.php'))
                $_GET['p'] = '404';
        }
        else
            $_GET['p'] = 'connexion';
            
        include './pages/' . $_GET['p'] . '.php';
            
        $content = ob_get_contents();
    ob_end_clean();
    
    if(!isset($no_header))
        include './theme/template.php';
    else
        echo $content;
?>